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

use Zend\Http\Client;
use Zend\Http\Request;

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

                $drequest['response'] = $data['g-recaptcha-response'];
                $drequest['secret'] = '6Le7B7IUAAAAADCnt0Kv4ZiiT_eYSbPuizJcnRfd';

                if($_SERVER["SERVER_NAME"] != 'goodbank.dev.br'){
                    $response = $this->postService($drequest);
                }

                if(1 === 1 || $response->success || $_SERVER["SERVER_NAME"] == 'goodbank.dev.br') {


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

                    if ($result->isValid()) {

                        /**
                         * @var User $user
                         * @var User $userService
                         */
                        $user = $result->getIdentity();

                        $user = $this->getServiceLocator()->get('Register\Service\User')->getUser($user['user']->getId());

                        $sessionStorage->write($user, null);

                        return $this->redirect()->toRoute('admin', array('controller' => 'admin'));
                    } else {
                        if (!empty($result->getMessages())) {
                            $_SESSION['link_ativacao_resend'] = false;
                            foreach ($result->getMessages() as $message) {

                                if (strstr($message, 'Usuário inativo')) {
                                    $_SESSION['link_ativacao_resend'] = true;
                                    $_SESSION['email_ativacao_resend'] = $data['email'];
                                }

                                $this->flashMessenger()->addErrorMessage($message);
                            }
                        } else {
                            $db_user = $this->getEm()->getRepository('Register\Entity\User')->findOneByEmail($data['email']);
                            if ($db_user && $db_user->getPassword() == md5('123')) {
                                $this->flashMessenger()->addErrorMessage('Você é um usuário antigo no sistema, sua senha foi alterada devido a importação de dados entre sistemas, por favor clique em "Esqueceu a senha?" para gerar uma nova senha.');
                            } else {
                                $this->flashMessenger()->addErrorMessage('Usuário ou senha inválido');
                            }
                        }

                        return $this->redirect()->toRoute('user-auth');
                    }
                }else{
                    $this->flashMessenger()->addErrorMessage('Por favor faça a verificação se você não for um robo');
                    return $this->redirect()->toRoute('admin', array('controller' => 'admin'));
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
                header('Location: /register?sponsor=' . $data['sponsor']->getFriendlyUrl());
                die;
            }

            if(isset($data['password']) && $data['password'] != $data['confirmation']){
                $this->flashmessenger()->addErrorMessage("As senhas não conferem!");
                header('Location: /register?sponsor=' . $data['sponsor']->getFriendlyUrl());
                die;
            }

            $entity = $service->insert($data);

            if($entity instanceof User){
                $msg = 'Parabéns você se cadastrou com sucesso, acesse sua caixa de entrada e ative sua conta! Caso não tenha recebido o e-mail de ativação entre em contato com o administrador.';
                $this->flashmessenger()->addSuccessMessage($msg);

                return $this->redirect()->toRoute('user-auth');
            }else{
                $msg = "Houve um erro ao tentar se cadastrar, entre em contato com o administrador";
                $this->flashmessenger()->addErrorMessage($msg);

                header('Location: /register?sponsor=' . $data['sponsor']->getFriendlyUrl());
                die;
            }
        }

        if(isset($_GET['sponsor']) && $_GET['sponsor'] != ''){
            $db_sponsor = $em->getRepository('Register\Entity\User')
                ->findOneBy([
                    'friendly_url' => $_GET['sponsor']
                ]);
        }else{
            $db_sponsor = null;
        }

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
                $rota = $_SERVER['REQUEST_SCHEME'].'://'.$_SERVER['SERVER_NAME'].$this->url()->fromRoute('user-auth');
                $result = $service->lostPassword($data,$rota);

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

    public function resendConfirmAction() {

        $request = $this->getRequest();

        if($request->isPost()){
            $data = $request->getPost()->toArray();

            /**
             * @var \Register\Service\User $service
             */
            $service = $this->getServiceLocator()->get('Register\Service\User');
            $return = $service->sendConfirm($data);

            if($return['result']){
                $this->flashMessenger()->addSuccessMessage('E-mail de confirmação reenviado, por favor confira sua caixa de entrada, caso o e-mail não tenha chegado, procure na caixa de span');
                return $this->redirect()->toRoute('user-auth');
            }else{
                $this->flashMessenger()->addErrorMessage('Houve algum erro ao enviar o e-mail de confirmação, por favor entre em contato com o administrador');
                return $this->redirect()->toRoute('user-auth');
            }
        }

        return $this->redirect()->toRoute('user-auth');
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

    public function postService($data){

        $request = new Request();
        $request->setMethod(Request::METHOD_POST);
        $request->setUri('https://www.google.com/recaptcha/api/siteverify?secret='.$data['secret'].'&response='.$data['response']);
        $request->getHeaders()->addHeaderLine('Content-Type:  application/json');

        $config = array(
            'adapter'   => 'Zend\Http\Client\Adapter\Curl',
            'curloptions' => array(CURLOPT_FOLLOWLOCATION => true),
        );

        $client = new Client();
        $client->setRequest($request);
        $client->setOptions($config);
        $client->send();
        $response = $client->getResponse()->getBody();

        return json_decode($response);
    }
}
