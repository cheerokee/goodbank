<?php
namespace Admin\Controller;

use Zend\Mvc\Controller\AbstractActionController,
    Zend\View\Model\ViewModel;

class IndexController extends AbstractActionController{
    protected $em;
    
    public function __construct(){
    }
    
    public function indexAction(){

        if(isset($_REQUEST['action'])){

            switch ($_REQUEST['action']){
                case "announcement":
                    return $this->redirect()->toRoute('job/default',array('controller' => 'job','action' => 'index'));
                    die;
                    break;
            }
        }

        return new ViewModel(array('em' => $this->getEm()));
    }

    public function notHavePermissionAction(){
        $this->layout()->setTemplate('layout/admin_auth.phtml');
        return new ViewModel(array());
    }
    
    /**
     *
     * @return EntityManager
     */
    protected function getEm(){
        if(null === $this->em){
            $this->em = $this->getServiceLocator()->get('Doctrine\ORM\EntityManager');
            return $this->em;
        }
    }

}
