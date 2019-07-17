<?php

namespace Register\Controller;

use Zend\Mvc\Controller\AbstractActionController,
    Zend\View\Model\ViewModel;

use Register\Form\User as FormUser;

class IndexController extends AbstractActionController
{
    public function registerAction() 
    {
        $form = new FormUser;
        $request = $this->getRequest();
        
        if($request->isPost())
        {
            $form->setData($request->getPost());
            if($form->isValid())
            {
                $service = $this->getServiceLocator()->get('Register\Service\User');
                if($service->insert($request->getPost()->toArray())) 
                {
                    $fm = $this->flashMessenger()
                            ->setNamespace('User')
                            ->addMessage("Usuário cadastrado com sucesso");
                }
                
                return $this->redirect()->toRoute('user-register');
            }
        }
        
        $messages = $this->flashMessenger()
                ->setNamespace('User')
                ->getMessages();
        
        return new ViewModel(array('form'=>$form,'messages'=>$messages));
    }
    
    public function activateAction()
    {
        $activationKey = $this->params()->fromRoute('key');
        
        $userService = $this->getServiceLocator()->get('Register\Service\User');
        $result = $userService->activate($activationKey);

        if($result){
            $this->flashmessenger()->addSuccessMessage("Você foi ativado com sucesso!");
            return $this->redirect()->toRoute('user-auth',array('controller'=>'index'));
        }else{
            $this->flashmessenger()->addErrorMessage("Houve um erro na ativação do usuário");
            return $this->redirect()->toRoute('user-auth',array('controller'=>'index'));
        }
    }

    public function getLogin()
    {
        $session = (array)$_SESSION['Admin'];

        foreach ($session as $v) {
            if (isset($v['storage']))
                $login = $v['storage'];
        }
        return $login;
    }
}
