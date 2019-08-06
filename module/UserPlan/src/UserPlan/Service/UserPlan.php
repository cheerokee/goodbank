<?php
namespace UserPlan\Service;

use Base\Mail\Mail;
use Base\Service\AbstractService;
use Solicitation\Entity\Solicitation;
use Transaction\Entity\Transaction;
use Zend\Mail\Transport\Smtp as SmtpTransport;
use Doctrine\ORM\EntityManager;



class UserPlan extends AbstractService{

    protected $em;
    protected $transport;
    protected $view;
    protected $configurationMail;

    public function __construct(EntityManager $em, SmtpTransport $transport, $view) {
        parent::__construct($em);

        $this->entity = 'UserPlan\Entity\UserPlan';
        $this->transport = $transport;
        $this->view = $view;
    }

    /**
     * @param \UserPlan\Entity\UserPlan $db_user_plan
     */
    public function calcBalance($db_user_plan){
        /**
         * @var Transaction[] $db_transactions
         */

        $rendimento = 0;
        /** SOMENTE RENDIMENTOS **/
        $db_transactions = $this->em->getRepository('Transaction\Entity\Transaction')->findBy(array(
            'user_plan' =>  $db_user_plan,
            'user'      =>  $db_user_plan->getUser(),
            'type'      =>  0 //CREDITO
        ));

        if(!empty($db_transactions))
        {
            foreach($db_transactions as $db_transaction)
            {
                $rendimento += $db_transaction->getValue();
            }
        }

        /** DIVIDIR OS SAQUES POR TODOS OS TIPOS DE CREDITO POR O SAQUE FEITO NO SISTEMA É INDEPENDETE DE APORTE **/
        $tots = $this->getTots($db_user_plan->getUser());
        $tot_debito     = $tots['tot_debito'];
        $tot_credito    = $tots['tot_credito'];

        /**
         * FAZER REGRA DE 3
         *
         * Soma de todos Cŕeditos       Soma de todos os Debitos
         *                         X
         * Rendimento                       ?
         *
         **/

        $debito = $this->debitoDiluido($tot_debito,$tot_credito,$rendimento);

//        echo 'Aporte: '. $db_user_plan->getName() . '<br />';
//        echo 'Total de Débito: ' . $tot_debito . '<br />';
//        echo 'Total de Crédito: ' . $tot_credito . '<br />';
//        echo 'Valor a ser retirado do rendimento: ' . $debito . '<br />';
//        echo 'Total de Rendimento do Aporte: ' . $rendimento . '<br /><br /><br />';

        /** Rendimento menos o debito diluído entre os creditos  **/
        return $rendimento - $debito;
    }

    public function getTots($user){
        /** DIVIDIR OS SAQUES POR TODOS OS TIPOS DE CREDITO POR O SAQUE FEITO NO SISTEMA É INDEPENDETE DE APORTE **/
        $tot_debito = 0;

        $db_debitos = $this->em->getRepository('Transaction\Entity\Transaction')->findBy(array(
            'user'      =>  $user,
            'type'      =>  1 //DEBITO
        ));

        if(!empty($db_debitos))
        {
            foreach($db_debitos as $db_debito)
            {
                $tot_debito += $db_debito->getValue();
            }
        }

        $tot_credito = 0;

        $db_creditos = $this->em->getRepository('Transaction\Entity\Transaction')->findBy(array(
            'user'      =>  $user,
            'type'      =>  0 //CREDITO
        ));

        if(!empty($db_creditos))
        {
            foreach($db_creditos as $db_credito)
            {
                $tot_credito += $db_credito->getValue();
            }
        }
        return array('tot_debito' => $tot_debito,'tot_credito' => $tot_credito);
    }

    /**
     * Função tem por objetivo saber o debito diluido
     * @param float $tot_debito
     * @param float $tot_credito
     * @param float $residual
     * @return float $debito_diluido
     */
    public function debitoDiluido($tot_debito,$tot_credito,$residual){
        $debito_diluido = ($tot_debito > 0)? ( $tot_debito * $residual ) / $tot_credito : 0;
        return $debito_diluido;
    }

    public function sumComission($db_user_plan){
        $value = 0;

        /**
         * @var Transaction[] $db_transactions
         */

        $db_transactions = $this->em->getRepository('Transaction\Entity\Transaction')->findBy(array(
            'user_plan' => $db_user_plan,
            'user'      => $db_user_plan->getUser()
        ));

        if(!empty($db_transactions))
        {
            foreach($db_transactions as $db_transaction)
            {
                if($db_transaction->getType()){
                    $value -= $db_transaction->getValue();
                }else{
                    $value += $db_transaction->getValue();
                }
            }
        }

        return $value;
    }

    public function sendWithdrawal($entity,$rota) {
        /**
         * @var Solicitation $entity
         */
        $value = 0;
        if($entity->getUserPlan()){
            $db_user_plan = $entity->getUserPlan();
            $db_user = $db_user_plan->getUser();


            $value = ($entity->getValue() * 1) + $db_user_plan->getPlan()->getPrice();
        }else{
            $db_user = $entity->getUser();
            $value = $entity->getValue();
        }

        $data = array(
            'to'  =>  array(
                $this->getConfigurationMail()['mail']['connection_config']['from'] =>
                $this->getConfigurationMail()['mail']['connection_config']['name_from']
            ),
            'from'    =>  array(
                $db_user->getEmail() => $db_user->getName()
            ),
            'name'  => $db_user->getName(),
            'value' => "R$" . number_format($value, 2, ',', '.'),
            'id'    => $entity->getId(),
            'email' => $db_user->getEmail(),
            'type'  => $entity->getTypeStr(),
            'rota'  => $rota,
        );

        $subject = 'Solicitação de ' . $entity->getTypeStr();
        $return = $this->sendMail($data,$subject,'solicitation');

        return $return;
    }

    public function notificaComprovante($entity,$rota){
        $data = array(
            'to'  =>  array(
                $this->getConfigurationMail()['mail']['connection_config']['from'] =>
                $this->getConfigurationMail()['mail']['connection_config']['name_from']
            ),
            'from'    =>  array(
                $entity->getUser()->getEmail() => $entity->getUser()->getName()
            ),
            'name'  => $entity->getUser()->getName(),
            'value' => "R$" . number_format($entity->getPlan()->getPrice(), 2, ',', '.'),
            'name_plan' => $entity->getPlan()->getName(),
            'data'  => new \DateTime('now'),
            'id'    => $entity->getId(),
            'email' => $entity->getUser()->getEmail(),
            'rota'  => $rota,
        );

        $subject = 'Aporte Realizado';
        $return = $this->sendMail($data,$subject,'notify-aporte');

        return $return;

    }

    public function notificaExpiration($entity,$rota){
        $data = array(
            'from'  =>  array(
                $this->getConfigurationMail()['mail']['connection_config']['from'] =>
                $this->getConfigurationMail()['mail']['connection_config']['name_from']
            ),
            'to'    =>  array(
                $entity->getUser()->getEmail() => $entity->getUser()->getName()
            ),
            'name'  => $entity->getUser()->getName(),
            'value' => "R$" . number_format($entity->getPlan()->getPrice(), 2, ',', '.'),
            'name_plan' => $entity->getPlan()->getName(),
            'data'  => new \DateTime('now'),
            'id'    => $entity->getId(),
            'email' => $entity->getUser()->getEmail(),
            'rota'  => $rota,
        );

        $subject = 'Aporte Expirado';
        $return = $this->sendMail($data,$subject,'notify-expiration');

        return $return;
    }

    public function notificaAprovacao($entity,$rota){
        $data = array(
            'from'  =>  array(
                $this->getConfigurationMail()['mail']['connection_config']['from'] =>
                    $this->getConfigurationMail()['mail']['connection_config']['name_from']
            ),
            'to'    =>  array(
                $entity->getUser()->getEmail() => $entity->getUser()->getName()
            ),
            'name'  => $entity->getUser()->getName(),
            'value' => "R$" . number_format($entity->getPlan()->getPrice(), 2, ',', '.'),
            'name_plan' => $entity->getPlan()->getName(),
            'data'  => new \DateTime('now'),
            'id'    => $entity->getId(),
            'email' => $entity->getUser()->getEmail(),
            'rota'  => $rota,
        );

        $subject = 'Parabéns seu aporte foi aprovado';
        $return = $this->sendMail($data,$subject,'notify-aprovacao');

        return $return;
    }

    public function sendMail($data,$subject, $template){
        $mail = new Mail($this->transport, $this->view,$template);
        $mail->setData($data)->prepare();
        $result = $mail->send($this,$subject);

        return $result;
    }

    public function sendMailSelf(array $dataEmail,$subject, $template){

        $mail = new Mail($this->transport, $this->view,$template);
        $mail   ->setTo($dataEmail['email'])
            ->setData($dataEmail)
            ->prepare();

        $result = $mail->selfSend($dataEmail,$this,$subject);

        return $result;
    }

    public function getConfigurationMail()
    {
        return $this->configurationMail;
    }

    public function setConfigurationMail($configurationMail)
    {
        $this->configurationMail = $configurationMail;
    }
}


























?>
