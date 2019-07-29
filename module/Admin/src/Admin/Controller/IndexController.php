<?php
namespace Admin\Controller;

use Base\Controller\BaseFunctions;
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
        $em = $this->getEm();

        $bit_str = json_decode(file_get_contents("https://www.mercadobitcoin.net/api/BTC/ticker/"),true);
        if($bit_str){
            $db_config = $em->getRepository('Configuration\Entity\Configuration')->findOneByChave('BITCOIN');
            if($db_config){
                $db_config->setValue($bit_str['ticker']['last']);

                $em->persist($db_config);
                $em->flush();
            }
        }

        $dol_str = json_decode(file_get_contents("https://economia.awesomeapi.com.br/all/USD-BRL"),true);
        if($dol_str){
            $db_config = $em->getRepository('Configuration\Entity\Configuration')->findOneByChave('DOLLAR');
            if($db_config){
                $db_config->setValue((new BaseFunctions())->moedaToFloat($dol_str['USD']['low']));

                $em->persist($db_config);
                $em->flush();
            }
        }

        /**
         * @var User $db_user
         * @var Transaction[] $db_transactions
         * @var UserPlan[] $db_user_plans
         * @var User[] $db_indicados
         */
        $db_cycle_active = $em->getRepository('Cycle\Entity\Cycle')->findOneByStatus(1);
        $db_user = $this->getLogin();

        $db_user_plans_all = $em->getRepository('UserPlan\Entity\UserPlan')->findBy(array(
            'status' => 1
        ));

        $db_user_plans_all_deactives = $em->getRepository('UserPlan\Entity\UserPlan')->findBy(array(
            'status' => 0
        ));

        $db_solicitations_all_deactives = $em->getRepository('Solicitation\Entity\Solicitation')
            ->findBy(array(
                'closed' => 0
            ));

        $db_user_plans = $em->getRepository('UserPlan\Entity\UserPlan')->findBy(array(
           'user' => $db_user,
           'status' => 1
        ));

        $db_transactions = $em->getRepository('Transaction\Entity\Transaction')->findBy(array(
           'user' => $db_user
        ));

        $db_transactions_all = $em->getRepository('Transaction\Entity\Transaction')->findAll();

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

        $total_rendimento_all = 0;
        if(!empty($db_transactions_all)){
            foreach($db_transactions_all as $db_transaction)
            {
                if($db_transaction->getType()){
                    $total_rendimento_all -= $db_transaction->getValue();
                }else{
                    $total_rendimento_all += $db_transaction->getValue();
                }
            }
        }

        if(!empty($db_user_plans)){
            foreach($db_user_plans as $db_user_plan)
            {
                $total_investido += $db_user_plan->getPlan()->getPrice();
            }
        }

        $total_investido_all = 0;
        if(!empty($db_user_plans_all)){
            foreach($db_user_plans_all as $db_user_plan)
            {
                $total_investido_all += $db_user_plan->getPlan()->getPrice();
            }
        }

        return new ViewModel(array(
            'db_cycle_active' => $db_cycle_active,
            'db_user' => $db_user,
            'db_transactions' => $db_transactions,
            'db_transactions_all' => $db_transactions_all,
            'db_user_plans' => $db_user_plans,
            'db_user_plans_all' => $db_user_plans_all,
            'total_rendimento' => $total_rendimento,
            'total_rendimento_all' => $total_rendimento_all,
            'total_investido' => $total_investido,
            'total_investido_all' => $total_investido_all,
            'db_indicados' => $db_indicados,
            'db_user_plans_all_deactives' => $db_user_plans_all_deactives,
            'db_solicitations_all_deactives' => $db_solicitations_all_deactives
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
