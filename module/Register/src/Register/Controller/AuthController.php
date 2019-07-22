<?php

namespace Register\Controller;

use Base\Controller\BaseFunctions;
use Register\Auth\Adapter;
use Zend\Mvc\Controller\AbstractActionController,
    Zend\View\Model\ViewModel;

use Zend\Authentication\AuthenticationService,
    Zend\Authentication\Storage\Session as SessionStorage,
    Zend\Authentication\Result;

use Register\Form\Login as LoginForm;
use Register\Entity\User;

class AuthController extends AbstractActionController
{

    public function indexAction()
    {
        $form = new LoginForm();
        $request = $this->getRequest();
        $error = false;
        
        $this->layout()->setTemplate('layout/admin_auth.phtml');

        if($request->isPost()){

            $form->setData($request->getPost());

            if($form->isValid()){
                $data = $request->getPost()->toArray();

                // Criando Storage para gravar sessão da autenticação
                $sessionStorage = new SessionStorage("User");

                $auth = new AuthenticationService();
                $auth->setStorage($sessionStorage);//Definindo o SessionStorage para a auth

                /**
                 * @var Adapter
                 */
                $authAdapter = $this->getServiceLocator()->get('Register\Auth\Adapter');
                $authAdapter->setUsername($data['email']);
                $authAdapter->setPassword($data['password']);

                /**
                 * @var Result $result
                 */
                $result = $authAdapter->authenticate();

                if($result->isValid()){

                    /**
                     * @var User $user
                     * @var User $userService
                     */
                    $user = $result->getIdentity();

                    $user = $this->getServiceLocator()->get('Register\Service\User')->getUser($user['user']->getId());

                    $sessionStorage->write($user,null);

                    return $this->redirect()->toRoute('admin',array('controller'=>'admin'));
                }else{
                    if(!empty($result->getMessages())){
                        foreach ($result->getMessages() as $message){
                            $this->flashMessenger()->addErrorMessage($message);
                        }
                    }else{
                        $this->flashMessenger()->addErrorMessage('Usuário ou senha inválido');
                    }

                    return $this->redirect()->toRoute('user-auth');
                }
            }
        }
        
        $auth = new AuthenticationService();
        $auth->setStorage(new SessionStorage("User"));
        $db_users = $this->getEm()->getRepository('Register\Entity\User')->findAll();

        return new ViewModel(array(
            'form'=>$form,
            'error'=>$error,
            'login' => $auth->getIdentity('User'),
            'people' => $db_users
        ));
    }

    public function registerAction()
    {
        $em = $this->getEm();
        $request = $this->getRequest();

        $this->layout()->setTemplate('layout/admin_auth.phtml');

        if($request->isPost()){

            $data = $request->getPost()->toArray();

            if(isset($data['sponsor'])){
                $data['sponsor'] = $em->getRepository('Register\Entity\User')->findOneById($data['sponsor']);
            }

            /**
             * @var \Register\Service\User $service
             * @var Register\Form\User $form
             */
            $service = $this->getServiceLocator()->get('Register\Service\User');

            if($service->getByMail($data['email'])){
                $this->flashmessenger()->addErrorMessage("O e-mail já está sendo utilizado!");
                return $this->redirect()->toRoute('user-register');
            }

            if(isset($data['password']) && $data['password'] != $data['confirmation']){
                $this->flashmessenger()->addErrorMessage("As senhas não conferem!");
                return $this->redirect()->toRoute('user-register');
            }

            $entity = $service->insert($data);

            if($entity instanceof User){
                $msg = 'Parabéns você se cadastrou com sucesso, acesse sua caixa de entrada e ative sua conta! Caso não tenha recebido o e-mail de ativação entre em contato com o administrador.';
                $this->flashmessenger()->addSuccessMessage($msg);

                return $this->redirect()->toRoute('user-auth');
            }else{
                $msg = "Houve um erro ao tentar se cadastrar, entre em contato com o administrador";
                $this->flashmessenger()->addErrorMessage($msg);

                return $this->redirect()->toRoute('user-register');
            }
        }

        $db_sponsor = $em->getRepository('Register\Entity\User')->findOneById($_GET['sponsor']);

        return new ViewModel(array('db_sponsor' => $db_sponsor));
    }
    
    public function logoutAction()
    {
        $auth = new AuthenticationService;
        $auth->setStorage(new SessionStorage("User"));
        $auth->clearIdentity();

        return $this->redirect()->toRoute('user-auth');
    }
    
    public function lostpasswordAction(){
        $this->layout()->setTemplate('layout/admin_auth.phtml');
    
        $form = new LoginForm;
        $request = $this->getRequest();
        $error = false;
    
        if($request->isPost()){
    
            $form->setData($request->getPost());
    
            if($form->isValid()){
                $data = $request->getPost()->toArray();

                /**
                 * @var \Register\Service\User $service
                 */
                $service = $this->getServiceLocator()->get('Register\Service\User');

                $result = $service->lostPassword($data);

                if($result['result'])
                {
                    $this->flashmessenger()->addSuccessMessage($result['msg']);
                    return $this->redirect()->toRoute('user-auth',array(
                        'controller'=>'Auth'
                    ));
                }else{
                    $this->flashmessenger()->addErrorMessage($result['msg']);
                    return $this->redirect()->toRoute('lostpassword');
                }
            }
        }
    
        return new ViewModel(array('form'=>$form,'error'=>$error));
    }

    /**
     *
     * @return EntityManager
     */
    protected function getEm()
    {
        if(null === $this->em)
            $this->em = $this->getServiceLocator ()->get ('Doctrine\ORM\EntityManager');
    
            return $this->em;
    }
}
