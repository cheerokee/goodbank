<?php
namespace Admin\Controller;

use Register\Entity\User;
use Transaction\Entity\Transaction;
use UserPlan\Entity\UserPlan;
use Zend\Mvc\Controller\AbstractActionController,
    Zend\View\Model\ViewModel;
use Doctrine\ORM\EntityManager;

class IndexController extends AbstractActionController{
    public $em;
    
    public function __construct(){
    }
    
    public function indexAction(){

        /**
         * @var User $db_user
         * @var Transaction[] $db_transactions
         * @var UserPlan[] $db_user_plans
         * @var User[] $db_indicados
         */
        $em = $this->getEm();
        $db_cycle_active = $em->getRepository('Cycle\Entity\Cycle')->findOneByStatus(1);
        $db_user = $this->getLogin();
        $db_user_plans = $em->getRepository('UserPlan\Entity\UserPlan')->findBy(array(
           'user' => $db_user,
           'status' => 1
        ));

        $db_transactions = $em->getRepository('Transaction\Entity\Transaction')->findBy(array(
           'user' => $db_user
        ));

        $db_indicados = $em->getRepository('Register\Entity\User')->findBySponsor($db_user);

        $total_rendimento = 0;
        $total_investido = 0;

        if(!empty($db_transactions)){
            foreach($db_transactions as $db_transaction)
            {
                if($db_transaction->getType()){
                    $total_rendimento -= $db_transaction->getValue();
                }else{
                    $total_rendimento += $db_transaction->getValue();
                }
            }
        }

        if(!empty($db_user_plans)){
            foreach($db_user_plans as $db_user_plan)
            {
                $total_investido += $db_user_plan->getPlan()->getPrice();
            }
        }

        return new ViewModel(array(
            'db_cycle_active' => $db_cycle_active,
            'db_user' => $db_user,
            'db_transactions' => $db_transactions,
            'db_user_plans' => $db_user_plans,
            'total_rendimento' => $total_rendimento,
            'total_investido' => $total_investido,
            'db_indicados' => $db_indicados
        ));
    }

    public function notHavePermissionAction(){
        $this->layout()->setTemplate('layout/admin_auth.phtml');
        return new ViewModel(array());
    }

    public function setEm(EntityManager $em)
    {
        $this->em = $em;
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

}
