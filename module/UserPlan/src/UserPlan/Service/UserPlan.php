<?php
namespace UserPlan\Service;

use Base\Mail\Mail;
use Base\Service\AbstractService;
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
        $value = 0;

        /**
         * @var Transaction[] $db_transactions
         */

        $db_transactions = $this->em->getRepository('Transaction\Entity\Transaction')->findBy(array(
            'user_plan' => $db_user_plan
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

    public function notificaRenovacao($entity,$rota,$renew = false){
        $operacao = ($renew)?'Renovação':'Ativação';
        /**
         * @var \EA\Entity\EAContract $entity
         */
        $data = array(
            'nome'  => $entity->getUser()->getNome(),
            'data'  => new \DateTime('now'),
            'id'    => $entity->getId(),
            'email' => $entity->getUser()->getEmail(),
            'rota'  => $rota,
            'service_name' => $entity->getEa()->getName(),
            'service_type' => $entity->getEa()->getTypeStr(),
            'operacao' =>  $operacao,
            'conta' =>  $entity->getEaXmAccount()->getNumber()
        );

        if($renew){
            $subject = 'Renovacao Expert Advisor / Espelhamento: Renovacao realizada com sucesso';
        }else{
            $subject = 'Ativacao Expert Advisor / Espelhamento: Solicitacao de Ativacao';
        }

        return $this->sendMail($entity->getUser(),$data,$subject,'notify-renovacao');
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
