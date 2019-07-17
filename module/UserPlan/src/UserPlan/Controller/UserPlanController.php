<?php

namespace UserPlan\Controller;

use Base\Controller\CrudController;
use Cycle\Entity\Cycle;
use Solicitation\Entity\Solicitation;
use Transaction\Entity\Transaction;
use UserPlan\Service\UserPlan;
use Zend\View\Model\ViewModel;
use UserPlan\Entity\UserPlan as Contract;

class UserPlanController extends CrudController{
    public function __construct() {
        $this->title = $this->translate("Planos dos Usuários");
        $this->table = 'UserPlan';
        $this->entity = 'UserPlan\Entity\\'.$this->table ;
        $this->service = 'UserPlan\Service\\'.$this->table ;
        $this->form = 'UserPlan\Form\\'.$this->table ;
        $this->controller = "user-plan";
        $this->route = "user-plan/default";

        $this->_listView = array(
            'title' => $this->title,
            'icon' => 'hs-admin-wallet',
            'route' => $this->route,
            'controller' => $this->controller,
            'actions' => array(
                'enable' =>true,
                'defaults' => array(
                    'edit' => array(
                        'enable' => true,
                        'class' => 'btn btn-info',
                        'icon' => 'fa fa-edit',
                        'title' => 'Editar',
                        'authorize' => false
                    ),
                    'delete' => array(
                        'enable' => true,
                        'class' => 'btn btn-danger decision',
                        'icon' => 'fa fa-trash',
                        'title' => 'Excluir',
                        'authorize' => false
                    ),
                    'view' => array(
                        'enable' => false,
                        'class' => 'btn btn-info',
                        'icon' => 'fa fa-eye',
                        'title' => 'Visualizar'
                    ),
                ),
            ),
            'fields' => array(
                'id'=>array(
                    'label' => $this->translate('Id'),
                    'list' => true,
                ),
                'user'=>array(
                    'label' => $this->translate('Usuário'),
                    'list' => true,
                ),
                'plan'=>array(
                    'label' => $this->translate('Plano'),
                    'list' => true,
                ),
                'paymentMethod'=>array(
                    'label' => $this->translate('Forma de Pagamento'),
                    'list' => true,
                ),
                'statusStr'=>array(
                    'label' => $this->translate('Status'),
                    'list' => true,
                ),
                'wallet'=>array(
                    'label' => $this->translate('Carteira'),
                    'list' => true,
                ),
                'firstCycle'=>array(
                    'label' => $this->translate('Primeiro Ciclo'),
                    'list' => true,
                )
            ),
            'filters' => array(
                'user' => array(
                    'label'     => 'Usuário',
                    'type'      => 'autocomplete',
                    'column'    => 'col-md-12'
                ),
                'plan' => array(
                    'label'     => 'Plano',
                    'type'      => 'custom',
                    'column'    => 'col-md-12'
                ),
                'payment-method' => array(
                    'label'     => 'Forma de Pagamento',
                    'type'      => 'custom',
                    'column'    => 'col-md-12'
                ),
                'wallet' => array(
                    'label'     => 'Carteira',
                    'type'      => 'autocomplete',
                    'column'    => 'col-md-12'
                ),
                'status' => array(
                    'label'     => 'Status',
                    'type'      => 'select',
                    'column'    => 'col-md-12'
                ),
            )
        );
    }

    public function newAction($request = null, $form = null, $redirect = null)
    {
        $em = $this->getEm();
        $request = $this->getRequest();

        $view = parent::newAction($request, $form, $redirect);

        if($request->isPost()){
            $data = $request->getPost()->toArray();

            if(isset($_SESSION['entity_id'])) {
                $db_entity = $em->getRepository('UserPlan\Entity\UserPlan')->findOneById($_SESSION['entity_id']);

                /**
                 * @var UserPlan $service
                 */
                $service = $this->getServiceLocator()->get("UserPlan/Service/UserPlan");
                $result = $service->insertFile($db_entity,'receipt');

                if($result){
                    $rota = $_SERVER['REQUEST_SCHEME'].'://'.$_SERVER['SERVER_NAME'].$this->url()->fromRoute($this->controller.'/default',array(
                            'controller'=>$this->controller,'action'=>'edit','id'=>$db_entity->getId()
                    ));

                    if($data['reference'] == 'panel'){
                        $result = $service->notificaComprovante($db_entity,$rota);
                    }else{
                        $result = true;
                    }

                    if($result){
                        $this->flashMessenger()->addSuccessMessage('Aporte realizado com sucesso');
                    }else{
                        $this->flashMessenger()->addErrorMessage('Houve algum erro na contratação do aporte');
                    }
                }else{
                    $this->flashMessenger()->addErrorMessage('Houve um erro ao cadastrar o comprovante');
                }

                unset($_SESSION['entity_id']);
                return $this->redirect()->toRoute($this->route,array('controller' => $this->controller,'page'=>1));
            }
        }

        return $view;
    }

    public function editAction($request = null, $form = null, $redirect = null)
    {
        $em = $this->getEm();
        $request = $this->getRequest();

        if($request->isPost()) {
            $post = $request->getPost();
            /**
             * @var UserPlan $service
             * @var \UserPlan\Entity\UserPlan $db_entity
             */
            $db_entity = $em->getRepository('UserPlan\Entity\UserPlan')->findOneById($this->params()->fromRoute('id',0));

            $service = $this->getServiceLocator()->get("UserPlan/Service/UserPlan");
            $service->insertFile($db_entity,'receipt');
            $data = $post->toArray();

            if($data['status'] != $db_entity->getStatus() && $data['status']){
                $data['approved_date'] = new \DateTime('now');
            }

            $post->fromArray($data);
            $request->setPost($post);
        }

        return parent::editAction($request, $form, $redirect); // TODO: Change the autogenerated stub
    }

    public function myInvestimentAction() {
        return new ViewModel(array());
    }

    public function panelInvestimentAction() {
        return new ViewModel(array());
    }

    public function contractSaveAction(){
        $em = $this->getEm();
        $request = $this->getRequest();
        if($request->isPost()) {
            $data = $request->getPost()->toArray();

            if(!isset($data['id']) && !((isset($data['accept_term']) && $data['accept_term'] == 'on'))){
                echo json_encode(array('result' => false,'message' => 'Você precisa assinar o termo!'));
                die;
            }

            $db_plan = $em->getRepository('Plan\Entity\Plan')->findOneById($data['plan_id']);
            $db_user = $em->getRepository('Register\Entity\User')->findOneById($data['user_id']);

            $new = false;
            $renew = false;

            /**
             * @var \UserPlan\Entity\UserPlan $db_contract
             */
            if(isset($data['id']) && $data['id'] != ''){
                $db_contract = $em->getRepository('UserPlan\Entity\UserPlan')->findOneById($data['id']);

                if(isset($data['renew'])){ // CASO NÃO SEJA UMA RENOVAÇÃO
                    $renew = true;
                }

            }else{
                $db_contract = new Contract();
                $new = true;
            }

            if(isset($data['wallet'])){
                $db_wallet = $em->getRepository('Wallet\Entity\Wallet')->findOneById($data['wallet']);
                $db_contract->setWallet($db_wallet);
            }

            if(isset($data['payment_method'])){
                $db_payment_method = $em->getRepository('PaymentMethod\Entity\PaymentMethod')->findOneById($data['payment_method']);
                $db_contract->setPaymentMethod($db_payment_method);
            }

            if(isset($data['status'])){
                $db_contract->setStatus(0);
            }

            $db_contract->setPlan($db_plan);
            $db_contract->setUser($db_user);

            $em->persist($db_contract);
            $em->flush();

            /**
             * INICIO CADASTRO COMPROVANTE
             */
            if(isset($_FILES['receipt'])){
                $destino = 'public/uploads/';
                mkdir('public/'.$destino,0777);
                $extension = explode('.',$_FILES['uploads']['name']);
                $uploaddir = $destino;
                $docDestinoName = bin2hex(random_bytes(16)).".".$extension[count($extension)-1];
                $destino = $uploaddir . $docDestinoName ;
                $origem = $_FILES['receipt']['tmp_name'];

                $result_receipt = $this->smartCopy($origem, $destino);
                if ($result_receipt) {
                    $db_contract->setReceipt($docDestinoName);
                    $em->persist($db_contract);
                }else{
                    $em->remove($db_contract);
                }

                $em->flush();

                if(!$result_receipt){
                    echo json_encode(array(
                        'result' => false,
                        'message' => 'Houve um erro ao cadastrar o comprovante, contrato cancelado, entre em contato com o administrador!'
                    ));
                    die;
                }
            }
            /**
             * FIM CADASTRO COMPROVANTE
             * NOTIFICAÇÃO DE USUÁRIO
             * @var EA $service
             */
            $service = $this->getServiceLocator()->get("UserPlan/Service/UserPlan");
            $rota = $_SERVER['REQUEST_SCHEME'].'://'.$_SERVER['SERVER_NAME'].$this->url()->fromRoute('user-plan/default',array('controller'=>'user-plan','action'=>'edit','id'=>$db_contract->getId()));

            if($new || $renew){
                $result = $service->notificaComprovante($db_contract,$rota,$renew);
            }else{
                $result = true;
            }

            if(!$result){
                $this->em->remove($db_contract);
                echo json_encode(array(
                    'result' => false,
                    'message' => 'Houve erro ao notificar o administrador, por favor, entre em contato com o Administrador!'
                ));
                die;
            }
            /**
             * FIM NOTIFICAÇÃO
             */

            if($new){
                echo json_encode(array(
                    'result' => true,
                    'message' => 'Contrato cadastrado com sucesso!',
                    'user_plan_id' => $db_contract->getId()
                ));
            }else{
                echo json_encode(array('result' => true,'message' => 'Contrato atualizado com sucesso!','contract_id' => $db_contract->getId()));
            }
            die;
        }
    }

    public function balanceAction() {

        $em = $this->getEm();
        $request = $this->getRequest();
        $ids = [];
        if($request->isPost()) {
            $data = $request->getPost()->toArray();
            if(!empty($data['ids'])){
                foreach ($data['ids'] as $id){
                    $ids[] = $id['id'];
                }
            }

            /**
             * @var \UserPlan\Entity\UserPlan[] $db_user_plans
             * @var UserPlan $service
             */

            $service = $this->getServiceLocator()->get("UserPlan/Service/UserPlan");

            $db_user_plans = $em->getRepository('UserPlan\Entity\UserPlan')->findByIds(implode(",",$ids));

            $balances = [];
            if(!empty($db_user_plans))
            {
                foreach($db_user_plans as $db_user_plan)
                {
                    $balance = $service->calcBalance($db_user_plan);
                    $balances[$db_user_plan->getId()] = $balance;
                }
            }

            echo json_encode($balances);
            die;
        }
    }

    public function sendCashOutAction(){
        $em = $this->getEm();
        $request = $this->getRequest();
        if($request->isPost()) {
            $data = $request->getPost()->toArray();
            $user_plan_id = $data['user_plan_id'];
            $value = $data['value'];
            $renovar = $data['renew'];
            $resgatar = $data['user_plan_id'];
            var_dump($data);
            echo json_encode(array());
            die;
        }
    }

    public function cashOutPanelAction() {
        $em = $this->getEm();
        $db_solicitation_id = $this->params()->fromRoute('id',0);
        $db_solicitation = $em->getRepository('Solicitation\Entity\Solicitation')->findOneById($db_solicitation_id);
        $db_user_plan = $db_solicitation->getUserPlan();
        $db_account = $db_user_plan->getAccount();
        $db_user = $db_user_plan->getUser();
        $db_cycles = $em->getRepository('Cycle\Entity\Cycle')->findBy(array(),array(
            'month' => 'DESC',
            'year'  => 'DESC'
        ));

        //$request = $this->getRequest();
        return new ViewModel(array(
            'db_solicitation'   =>  $db_solicitation,
            'db_user_plan'  =>  $db_user_plan,
            'db_account'    =>  $db_account,
            'db_user'       =>  $db_user,
            'db_cycles'        =>  $db_cycles
        ));
    }

    public function withdrawalAction() {
        /**
         * @var ZF\ContentNegotiation\Request $request
         */
        $em = $this->getEm();
        $request = $this->getRequest();
        if($request->isPost()){
            $data = $request->getPost()->toArray();
            /**
             * @var Solicitation $db_solicitation
             * @var Transaction $db_transaction
             */

            $value = str_replace(',','.',str_replace('.','',$data['price']));

            $db_solicitation = $em->getRepository('Solicitation\Entity\Solicitation')->findOneById($data['solicitation_id']);

            if(isset($data['cycle'])){
                $db_cycle = $em->getRepository('Cycle\Entity\Cycle')->findOneById($data['cycle']);
            }


            if($data['closed']){
                $db_solicitation->setClosed(true);
                $em->persist($db_solicitation);
                $em->flush();
            }

            $db_category_transaction = $em->getRepository('CategoryTransaction\Entity\CategoryTransaction')->findOneByCode('saque');

            if(!$db_category_transaction){
                throw new \Exception('Categoria de transação saque não definida!');
            }

            $db_transaction = new Transaction();
            $db_transaction->setValue($value);
            $db_transaction->setType(0);//Credito
            $db_transaction->setCategoryTransaction($db_category_transaction);
            $db_transaction->setCycle($db_cycle);
            $db_transaction->setDate((new \DateTime('now')));
            $db_transaction->setUserPlan($db_solicitation->getUserPlan());
            $em->persist($db_transaction);
            $em->flush();

            $this->flashMessenger()->addSuccessMessage('Pagamento efetuado com sucesso!');

            return $this->redirect()->toRoute('cash-out-panel',array('id' => $db_solicitation->getId()));
        }
    }

    public function renewAction() {
        /**
         * @var ZF\ContentNegotiation\Request $request
         */
        $em = $this->getEm();
        $request = $this->getRequest();
        if($request->isPost()){
            $data = $request->getPost()->toArray();

            /**
             * @var Solicitation $db_solicitation
             */
            $db_solicitation = $em->getRepository('Solicitation\Entity\Solicitation')->findOneById($data['solicitation_id']);
            if($data['closed']){
                $db_solicitation->setClosed(true);
                $em->persist($db_solicitation);
                $em->flush();
            }

            if(isset($data['cycle_start'])){
                $db_first_cycle = $em->getRepository('Cycle\Entity\Cycle')->findOneById($data['cycle_start']);
            }

            $db_user_plan = $db_solicitation->getUserPlan();
            $db_user_plan->setFirstCycle($db_first_cycle);
            $db_user_plan->setApprovedDate((new \DateTime('now')));
            $db_user_plan->setStatus(1);

            $em->persist($db_user_plan);
            $em->flush();

            $db_transactions = $em->getRepository('Transaction\Entity\Transaction')->findBy(array(
                'user_plan' => $db_user_plan
            ));

            if(!empty($db_transactions))
            {
                foreach($db_transactions as $db_transaction)
                {
                    $em->remove($db_transaction);
                    $em->flush();
                }
            }
            $this->flashMessenger()->addSuccessMessage('Renovação e pagamento efetuado com sucesso!');

            return $this->redirect()->toRoute('cash-out-panel',array('id' => $db_solicitation->getId()));
        }
    }

    public function rescueAction() {
        /**
         * @var ZF\ContentNegotiation\Request $request
         */
        $em = $this->getEm();
        $request = $this->getRequest();
        if($request->isPost()){
            $data = $request->getPost()->toArray();

            /**
             * @var Solicitation $db_solicitation
             */
            $db_solicitation = $em->getRepository('Solicitation\Entity\Solicitation')->findOneById($data['solicitation_id']);
            if($data['closed']){
                $db_solicitation->setClosed(true);
                $em->persist($db_solicitation);
                $em->flush();
            }

            $db_user_plan = $db_solicitation->getUserPlan();
            $db_user_plan->setStatus(3);

            $em->persist($db_user_plan);
            $em->flush();

            $this->flashMessenger()->addSuccessMessage('Resgate efetuado com sucesso!');

            return $this->redirect()->toRoute('cash-out-panel',array('id' => $db_solicitation->getId()));
        }
    }

    public function applyBalanceAction() {
        $this->layout()->setTemplate('layout/admin_auth.phtml');
        /**
         * @var ZF\ContentNegotiation\Request $request
         */
        $em = $this->getEm();
        //$request = $this->getRequest();

        /**
         * @var Cycle $db_cycle
         * @var \UserPlan\Entity\UserPlan[] $db_user_plans
         * @var Transaction $db_transaction
         */

        $db_category_transaction = $em->getRepository('CategoryTransaction\Entity\CategoryTransaction')->findOneByCode('rendimento');

        /** Buscar todos os aportes ativos **/
        $db_user_plans = $em->getRepository('UserPlan\Entity\UserPlan')->findByStatus(1);

        if(!empty($db_user_plans)){
            foreach ($db_user_plans as $db_user_plan)
            {
                /** Buscar um ciclo ativo, se não existir, criar **/
                $db_cycle = $em->getRepository('Cycle\Entity\Cycle')->findOneByStatus(1);
                if(!$db_cycle){
                    $last_cycle = $em->getRepository('Cycle\Entity\Cycle')
                        ->findOneBy(array(),array('year' => 'DESC','month' => 'DESC'));

                    if(!$last_cycle){
                        $db_cycle = new Cycle();
                        $db_cycle->setStatus(1);
                        $db_cycle->setMonth(date('m')*1);
                        $db_cycle->getYear(date('Y')*1);

                        $em->persist($db_cycle);
                        $em->flush();
                    }else{
                        if($last_cycle->getMonth() == 12){
                            $next_month = 1;
                            $next_year = $last_cycle->getYear()+1;
                        }else{
                            $next_month = $last_cycle->getMonth() + 1;
                            $next_year = $last_cycle->getYear();
                        }

                        $db_cycle = new Cycle();
                        $db_cycle->setStatus(1);
                        $db_cycle->setMonth($next_month);
                        $db_cycle->setYear($next_year);

                        $em->persist($db_cycle);
                        $em->flush();
                    }
                }

                $db_transaction = $em->getRepository('Transaction\Entity\Transaction')->findOneBy(array(
                    'user_plan' =>  $db_user_plan,
                    'cycle'     =>  $db_cycle,
                    'category_transaction' => $db_category_transaction
                ));

                if(!$db_transaction){
                    $db_transaction = new Transaction();

                    $db_transaction->setUserPlan($db_user_plan);
                    $db_transaction->setCycle($db_cycle);
                    $db_transaction->setCategoryTransaction($db_category_transaction);
                    $db_transaction->setType(0);
                }

                $db_transaction->setValue(1);
                $db_transaction->setDate((new \DateTime('now')));

                $em->persist($db_transaction);
                $em->flush();

                echo $db_cycle;
                echo $db_transaction;
                die;
            }
        }

        header("HTTP/1.1 200 OK");
        echo 'ok';
        die;
    }

    public function smartCopy($source, $dest, $options=array('folderPermission'=>0777,'filePermission'=>0777))
    {
        $result=false;

        if (is_file($source)) {
            if ($dest[strlen($dest)-1]=='/') {
                if (!file_exists($dest)) {
                    cmfcDirectory::makeAll($dest,$options['folderPermission'],true);
                }
                $__dest=$dest."/".basename($source);
            } else {
                $__dest=$dest;
            }
            $result=copy($source, $__dest);
            chmod($__dest,$options['filePermission']);

        } elseif(is_dir($source)) {
            if ($dest[strlen($dest)-1]=='/') {
                if ($source[strlen($source)-1]=='/') {
                    //Copy only contents
                } else {
                    //Change parent itself and its contents
                    $dest=$dest.basename($source);
                    @mkdir($dest);
                    chmod($dest,$options['filePermission']);
                }
            } else {
                if ($source[strlen($source)-1]=='/') {
                    //Copy parent directory with new name and all its content
                    @mkdir($dest,$options['folderPermission']);
                    chmod($dest,$options['filePermission']);
                } else {
                    //Copy parent directory with new name and all its content
                    @mkdir($dest,$options['folderPermission']);
                    chmod($dest,$options['filePermission']);
                }
            }

            $dirHandle=opendir($source);
            while($file=readdir($dirHandle))
            {
                if($file!="." && $file!="..")
                {
                    if(!is_dir($source."/".$file)) {
                        $__dest=$dest."/".$file;
                    } else {
                        $__dest=$dest."/".$file;
                    }
                    //echo "$source/$file ||| $__dest<br />";
                    $result=smartCopy($source."/".$file, $__dest, $options);
                }
            }
            closedir($dirHandle);

        } else {
            $result=false;
        }
        return $result;
    }
}
