<?php
namespace Base\Controller;

use Acl\Entity\Action;
use Acl\Entity\Possibility;
use Acl\Entity\Resource;
use DoctrineModule\Form\Element\ObjectSelect;
use Register\Entity\User;
use Zend\I18n\Validator\DateTime;
use Zend\Mvc\Controller\AbstractActionController,
    Zend\View\Model\ViewModel;

use Zend\Paginator\Paginator,
    Zend\Paginator\Adapter\ArrayAdapter;
use Doctrine\ORM\EntityManager;

use Zend\Permissions\Acl\Acl;
use Zend\Stdlib\Hydrator;

abstract class CrudController extends AbstractActionController{
    protected $em,$service,$entity,$form,$route,$controller;
    public $functions;

    public function __construct(){
        $this->functions = new BaseFunctions();
    }
    
    public function indexAction($list = null,$count = 10) {
        $list_custom = [];
        if(!empty($list)){
            $list_custom = $list;
        }

        if(isset($_SESSION['filter-form']))
        {
            if($_SESSION['filter-form']['controller'] == $this->controller){
                $list = $this->applyFilter($_SESSION['filter-form']);
            }else{
                unset($_SESSION['filter-form']);
            }
        }

        /**
         * @var User $db_login
         */
        $db_login = $this->getLogin();

        ///not-have-permission
        $request = $this->getRequest();

        if($request->isPost()) {
            $data = $request->getPost()->toArray();
            $list = $this->applyFilter($data);
        }

        $fk_entity = null;

        if($list === null){
            $list = $this->getEm()->getRepository($this->entity)->findAll();

            if($this->params()->fromRoute('fk',0))
            {
                $fk = $this->functions->toCamelCase($this->params()->fromRoute('fk',0),true);
                $find_method = 'findBy' . $fk;

                $list = $this->getEm()->getRepository($this->entity)->$find_method($this->params()->fromRoute('fk_id',0));
                $find_method = 'get' . $this->functions->toCamelCase( $fk , true);
                if(!empty($list)){
                    $fk_entity = $list[0]->$find_method();
                }
            }
        }

        $page = $this->params()->fromRoute('page');
        $page = ($page == '')?1:$page;

        if($this->_listView['order']){
            $qb = $this->getEm()->createQueryBuilder();
            $qb->select(array(
                'x'
            ))
            ->from($this->entity,'x')
            ->orderBy('x.order_value','ASC');
            $list = $qb->getQuery()->getResult();

            if(!empty($list_custom))
                $list = array_intersect($list,$list_custom);

            $paginator = new Paginator(new ArrayAdapter($list));
            $paginator->setCurrentPageNumber($page)->setDefaultItemCountPerPage(100000000);
        }else{

            if(!empty($list_custom))
                $list = array_intersect($list,$list_custom);

            $paginator = new Paginator(new ArrayAdapter($list));
            $paginator->setCurrentPageNumber($page)->setDefaultItemCountPerPage($count);
        }

        $form = $this->getForm();

        if($this->params()->fromRoute('fk',0)) {
            $fk = $this->params()->fromRoute('fk', 0);

            $fk_id = $this->params()->fromRoute('fk_id', 0);
            if ($fk != null && $fk_id != null) {
                $fk_route = str_replace(
                    $this->functions->camel2dashed($this->controller),
                    $this->functions->camel2dashed($fk),
                    $this->route
                );
            }
        }

        $view = new ViewModel(
            array(
                'em'            =>  $this->getEm(),
                'data'          =>  $paginator,
                'form'          =>  $form,
                'page'          =>  $page,
                'controller'    =>  $this->controller,
                '_listView'     =>  $this->_listView,
                'route'         =>  $this->route,
                'entity'        =>  $this->entity,
                'fk'            =>  $fk,
                'fk_id'         =>  $fk_id,
                'fk_entity'     =>  $fk_entity,
                'fk_route'      =>  $fk_route
            )
        );


        if($this->_listView){
            $view->setTemplate('base/crud/index');
        }

        $allowed = $this->isAllow($this->title,'Visualizar');

        if($allowed){
            return $view;
        }else{
            return $this->redirect()->toRoute('not-have-permission');
        }
    }

    public function newAction($request = null,$form = null,$redirect = null){
        $this->functions = new BaseFunctions();
        $em = $this->getEm();

        if(!isset($form)){
            $form = $this->getServiceLocator()->get($this->form);
        }

        $request = ($request == null) ? $this->getRequest() : $request;

        $this->requestProccess($request,$form,$redirect,'new');

        $view = new ViewModel(array(
            'entity' =>  $this->entity,
            'form' => $form,
            'controller' => $this->controller,
            'title'=> $this->title,
            'route' => $this->route,
            'em' => $this->getEm(),
            'fk' => $this->params()->fromRoute('fk',0),
            'fk_id' => $this->params()->fromRoute('fk_id',0),
            '_listView'     =>  $this->_listView,
        ));

        $view->setTemplate('base/crud/new.phtml');

        $allowed = $this->isAllow($this->title,'Criar');

        if($allowed){
            return $view;
        }else{
            return $this->redirect()->toRoute('not-have-permission');
        }

    }

    public function editAction($request = null,$form = null,$redirect = null){
        $this->functions = new BaseFunctions();
        $em = $this->getEm();

        if(!isset($form)){
            $form = $this->getServiceLocator()->get($this->form);
        }

        $repository = $em->getRepository($this->entity);
        $entity = $repository->find($this->params()->fromRoute('id',0));

        if($this->params()->fromRoute('id',0))
        {
            $form->setData((new Hydrator\ClassMethods())->extract($entity));
        }

        $request = ($request == null) ? $this->getRequest() : $request;

        $this->requestProccess($request,$form,$redirect,'edit');

        $view = new ViewModel(array(
            'form' => $form,
            'controller' => $this->controller,
            'title'=> $this->title,
            'route' => $this->route,
            'id' => $this->params()->fromRoute('id',0),
            'entity' => $this->entity,
            'em' => $this->getEm(),
            'fk'            => $this->params()->fromRoute('fk',0),
            'fk_id'            => $this->params()->fromRoute('fk_id',0),
            'action'    => 'edit',
            '_listView'     =>  $this->_listView
        ));

        $view->setTemplate('base/crud/edit.phtml');

        $allowed = $this->isAllow($this->title,'Editar');

        if($allowed){
            return $view;
        }else{
            return $this->redirect()->toRoute('not-have-permission');
        }
    }

    public function requestProccess($request,$form,$redirect,$action){
        $em = $this->getEm();

        if($request->isPost()){

            $form->setData($request->getPost());

            if($form->isValid() || !$form->isValid()){

                $data = $request->getPost()->toArray();

                $form = $this->getServiceLocator()->get($this->form);
                foreach ($form as $element) {
                    $type = $element->getAttributes()['type'];
                    if($type == 'date' || $type == 'datetime') {
                        $data[$element->getName()] = str_replace('T',' ',$data[$element->getName()]);
                        $data[$element->getName()] = new \DateTime($data[$element->getName()]);

                    }


                    if($element->getAttributes()['name'] == 'name' || $element->getAttributes()['name'] == 'title')
                    {
                        $data['friendlyUrl'] = $this->functions->strToFriendlyUrl($element->getValue());

                        $tmp = $em->getRepository($this->entity)->findOneByFriendlyUrl($data['friendlyUrl']);

                        if($tmp){
                            if($action == 'new' || ($action == 'edit' && $tmp->getId() != $data['id'])) {
                                $count_friendly = 1;
                                while ($tmp) {

                                    $data['friendlyUrl'] = $this->functions->strToFriendlyUrl($element->getValue()) . '-' . $count_friendly;

                                    $tmp = $em->getRepository($this->entity)->findOneByFriendlyUrl($data['friendlyUrl']);
                                    $count_friendly++;
                                }
                            }
                        }

                        $data['friendly_url'] = $data['friendlyUrl'];
                    }

                    if($element->getAttributes()['moeda']){
                        $data[$element->getName()] = $this->functions->moedaToFloat($data[$element->getName()]);
                    }

                    if($element instanceof ObjectSelect){
                        $field = $element->getName();
                        $setObject = $element->getProxy()->getTargetClass();

                        if($data[$field] != null){
                            $db_obj = $em->getRepository($setObject)->findOneById($data[$field]);

                            if($db_obj)
                            {
                                $data[$field] = $db_obj;
                            }
                        }
                    }

                    if(isset($_SESSION['empresa']) && $element->getName() == 'company')
                    {
                        $db_company = $this->getEm()->getRepository('Register\Entity\User')->findOneById($_SESSION['empresa']);
                        $data[$element->getName()] = $db_company;
                    }else if($element->getName() == 'company' && !($element instanceof ObjectSelect)){
                        $data[$element->getName()] = null;
                        continue;
                    }
                }

                $service = $this->getServiceLocator()->get($this->service);


                switch ($action){
                    case 'new':
                        $result = $service->insert($data,$this->controller);
                        if($result){
                            $_SESSION['entity_id'] = $result->getId();
                            $this->flashMessenger()->addSuccessMessage("Registro criado com sucesso!");
                        }
                        break;
                    case 'edit':
                        $result = $service->update($data,$this->controller);
                        if($result) {
                            $_SESSION['entity_id'] = $result->getId();
                            $this->flashMessenger()->addSuccessMessage("Registro alterado com sucesso!");
                        }
                        break;
                }
            }else{
                switch ($action){
                    case 'new':
                        $this->flashMessenger()->addErrorMessage("Houve um erro na criação do registro!");
                        break;
                    case 'edit':
                        $this->flashMessenger()->addErrorMessage("Houve um erro na atualização do registro!");
                        break;
                }

            }

            if($redirect === null){

                if($this->params()->fromRoute('fk',0) != null && $this->params()->fromRoute('fk_id',0) != null)
                {
                    return $this->redirect()->toRoute($this->functions->camel2dashed($this->controller) . '-join',array(
                        'fk' => $this->params()->fromRoute('fk',0),
                        'fk_id' => $this->params()->fromRoute('fk_id',0),
                        'page' => (isset($_GET['page']))?$_GET['page']:1
                    ));
                }else{
                    return $this->redirect()->toRoute($this->route,array('controller' => $this->controller,'page' => (isset($_GET['page']))?$_GET['page']:1));
                }
            }else{
                return $redirect;
            }

        }
    }

    public function viewAction(){
        $repository = $this->getEm()->getRepository($this->entity);
        $entity = $repository->find($this->params()->fromRoute('id',0));
        $form = $this->getServiceLocator()->get($this->form);
        $form->setData((new Hydrator\ClassMethods())->extract($entity));

        $view = new ViewModel(array(
            'form'      =>  $form,
            'route'     =>  $this->route,
            '_listView' =>  $this->_listView,
            'entity'    =>  $entity,
            'controller'=>  $this->controller
        ));

        $view->setTemplate('base/crud/view.phtml');

        $allowed = $this->isAllow($this->title,'Visualizar');

        return ($allowed)? $view : $this->redirect()->toRoute('not-have-permission');
    }

    public function clearFilterAction(){
        unset($_SESSION['filter-form']);
        return $this->redirect()->toRoute($this->route,array('controller'=>$this->controller));
    }

    public function applyFilter($data){
        $list = [];
        if(isset($data['filter-form']))
        {
            $list = $this->getEm()->getRepository($this->entity)->findByFilter($data);
            try{
                $_SESSION['filter-form'] = $data;
            }catch (\Exception $e){
                echo "Ops, parece que a entidade não tem seu repositorio definido Ex: Entity/EntityRepository, ou deu erro no repository";
                die;
            }
        }
        return $list;
    }
    
    /**
     * CrudController::getForm()
     * Obtendo a instância do form através do ServiceManager
     * Ou Intancia de forma normal o formulário, caso o mesmo
     * não tenha dependências
     *
     * @return \Zend\Form\Form
     */
    public function getForm()
    {
        $form = null;
        if ($this->getServiceLocator()->has($this->form))
            $form = $this->getServiceLocator()->get($this->form);
            else
                $form = new $this->form();
    
                if($this->validator){
                    $form->setInputFilter(new $this->validator($this->getEm()));
                }
    
                $form->add(array(
                    'name' => 'post-fieldset',
                    'type' => 'Base\Form\Fieldset\SubmitCancel',
                    'attributes' => array('class' => 'form-inline col-sm-offset-2'),
                    'options' => array('column-size' => 'sm-10 col-sm-offset-2')
                ));
    
                return $form;
    }
    
    public function deleteAction()
    {
        $this->functions = new BaseFunctions();
        $allowed = $this->isAllow($this->title,'Excluir');

        if($allowed){
            $service = $this->getServiceLocator()->get($this->service);

            if($service->delete($this->params()->fromRoute('id',0))) {

                if($this->params()->fromRoute('fk',0) != null && $this->params()->fromRoute('fk_id',0) != null)
                {
                    return $this->redirect()->toRoute($this->functions->camel2dashed($this->controller) . '-join',array(
                        'fk' => $this->params()->fromRoute('fk',0),
                        'fk_id' => $this->params()->fromRoute('fk_id',0)
                    ));
                }else{
                    return $this->redirect()->toRoute($this->route, array('controller' => $this->controller, 'action' => 'index', 'page' => (isset($_GET['page']))?$_GET['page']:1));
                }
            }
        }else{
            return $this->redirect()->toRoute('not-have-permission');
        }
    }

    /**
     * retorna um entity manager
     *
     * @return Ambigous <object, multitype:, \Doctrine\ORM\EntityManager>
     */
    public function getEm($entityName = null)
    {
        if (null === $this->em){
            if($this->emName)
                $this->em = $this->getServiceLocator()->get($this->emName);
                else
                    $this->em = $this->getServiceLocator()->get('Doctrine\ORM\EntityManager');
        }
    
        if($entityName !== null)
            return $this->em->getRepository($entityName);
    
            return $this->em;
    }

    public function getLogin(){

        $session = (array) $_SESSION['User'];
        /**
         * @var User $user
         */
        foreach($session as $v){
            if(isset($v['storage']))
                $login = $v['storage'];
        }

        if($login) {
            $db_login = $this->getEm()->getRepository('Register\Entity\User')->findOneById($login->getId());

            return $db_login;
        }else{
            return $this->redirect()->toRoute('not-have-permission');
        }
    }
    
    /**
     * Retorna o serviço crud da entidade insert,update,delete
     * @param String $serviceName - Novo serviço
     * @return \Base\Service\AbstractService
     */
    public function getService($serviceName=null)
    {
        $service = $this->getServiceLocator()->get(($serviceName)?$serviceName:$this->service);
        return $service;
    }

    public function setEm(EntityManager $em)
    {
        $this->em = $em;
    }
    
    public function paginator($list,$pageNumber,$count = 10)
    {
        $paginator = new Paginator(new ArrayAdapter($list));
        $paginator->setCurrentPageNumber($pageNumber);
        $paginator->setDefaultItemCountPerPage($count);
    
        return $paginator;
    }

    public function translate($str){
        return $str;
    }

    public function isAllow($resource,$privilege,$history_register = true){
        $em = $this->getEm();

        /** Se o Recurso ainda não foi criado na ACL então crie **/
        $db_resource = $em->getRepository('Acl\Entity\Resource')->findOneByName($resource);
        if(!($db_resource instanceof Resource))
        {
            /**
             * @var Resource $db_resource
             */
            $db_resource = new Resource();
            $db_resource->setName($resource);

            $em->persist($db_resource);
            $em->flush();
        }

        /** Se a Ação ainda não foi criado na ACL então crie **/
        $db_action = $em->getRepository('Acl\Entity\Action')->findOneByName($privilege);

        if(!($db_action instanceof Action))
        {
            /**
             * @var Resource $db_resource
             */
            $db_action = new Action();
            $db_action->setName($privilege);

            $em->persist($db_action);
            $em->flush();
        }

        /** Se a Possibilidade do recurso ainda não foi criado na ACL então crie **/
        $db_possibility = $em->getRepository('Acl\Entity\Possibility')->findOneBy(array(
            'resource'  => $db_resource,
            'action'    => $db_action
        ));

        if(!($db_possibility instanceof Possibility))
        {
            /**
             * @var Resource $db_resource
             */
            $db_possibility = new Possibility();
            $db_possibility->setResource($db_resource);
            $db_possibility->setAction($db_action);

            $em->persist($db_possibility);
            $em->flush();
        }

        /**
         * @var Acl $acl
         */
        $acl        = $this->getServiceLocator()->get('Acl\Permissions\Acl');
        $roles = array();

        if($this->getLogin() instanceof User)
        $roles      = $this->getLogin()->getUserRoles()->getValues();
        $allowed    = false;

        if(!empty($roles)){
            foreach($roles as $role){
                $allowed = $acl->isAllowed($role->getRole()->getName(),$resource,$privilege);

                if($allowed)
                {
                    break;
                }
            }
        }

        return $allowed;
    }
}
