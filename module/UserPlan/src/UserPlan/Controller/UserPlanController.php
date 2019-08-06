<?php

namespace UserPlan\Controller;

use Base\Controller\BaseFunctions;
use Base\Controller\CrudController;
use Cycle\Entity\Cycle;
use PercentGain\Entity\PercentGain;
use Plan\Entity\Plan;
use Register\Entity\User;
use Solicitation\Entity\Solicitation;
use Transaction\Entity\Transaction;
use UserPlan\Service\UserPlan;
use Zend\View\Model\ViewModel;
use UserPlan\Entity\UserPlan as Contract;
use PHPExcel_IOFactory;

class UserPlanController extends CrudController{
    public function __construct() {
        $this->title = $this->translate("Aportes");
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
                ),
                'approvedDateStr'=>array(
                    'label' => $this->translate('Data de Aprovação'),
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

            if($data['status'] != $db_entity->getStatus() && $data['status'] == 1){

                $db_cycle = $em->getRepository('Cycle\Entity\Cycle')->findOneById($data['first_cycle']);
                $data['approved_date'] = new \DateTime('now');

                /** NOTIFICAÇÃO DE APROVAÇÃO DE APORTE **/
                /**
                 * @var UserPlan $service
                 */
                $service = $this->getServiceLocator()->get("UserPlan/Service/UserPlan");
                $rota = $_SERVER['REQUEST_SCHEME'].'://'.$_SERVER['SERVER_NAME'].$this->url()->fromRoute('my-investiment');
                $service->notificaAprovacao($db_entity,$rota);
                $this->flashMessenger()->addSuccessMessage("O usuário foi notificado sobre a aprovação do aporte!");

                $this->payBonus($db_entity,$db_cycle);
            }

            $post->fromArray($data);
            $request->setPost($post);
        }

        return parent::editAction($request, $form, $redirect); // TODO: Change the autogenerated stub
    }

    public function payBonus($db_entity,$db_cycle,$notify){
        $em = $this->getEm();

        /** PAGAMENTO DE COMISSÃO **/
        /**
         * @var User $db_sponsor
         */
        $db_sponsor = $db_entity->getUser()->getSponsor();

        $db_category_transaction = $em
            ->getRepository('CategoryTransaction\Entity\CategoryTransaction')
            ->findOneBy(array('code' => 'first_commission'));

        if(!$db_category_transaction){
            throw new \Exception('O sistema precisa da categoria de transação de primeiro comissão cadastrada.');
        }

        if($db_sponsor){

            $comission = $db_entity->getPlan()->getPrice() * 0.10;

            $db_transactions_para_deletar = $em
                ->getRepository('Transaction\Entity\Transaction')
                ->findBy(array(
                    'user_plan' => $db_entity,
                    'cycle' => $db_cycle,
                    'category_transaction'  => $db_category_transaction
                ));

            if(!empty($db_transactions_para_deletar)){
                foreach ($db_transactions_para_deletar as $db_transaction_para_deletar){
                    if($db_transaction_para_deletar->getUser()->getId() != $db_entity->getUser()->getId() && $db_transaction_para_deletar->getUser()->getId() != $db_entity->getUser()->getSponsor()->getId()){
                        $em->remove($db_transaction_para_deletar);
                        $em->flush();
                    }
                }
            }

            $db_transaction = $em->getRepository('Transaction\Entity\Transaction')->findOneBy(array(
                'user' =>  $db_sponsor,
                'user_plan' => $db_entity,
                'category_transaction'  => $db_category_transaction,
                'type' => 0
            ));

            if(!$db_transaction){
                /**
                 * @var Transaction $db_transaction
                 */
                $db_transaction = new Transaction();
                $db_transaction->setUser($db_sponsor);
                $db_transaction->setUserPlan($db_entity);
            }

            $db_transaction->setType(0);
            /** O patrocinador vai ganhar 10% do valor do aporte **/
            $db_transaction->setValue($comission);
            $db_transaction->setCategoryTransaction($db_category_transaction);
            $db_transaction->setCycle($db_cycle);
            $db_transaction->setDate((new \DateTime('now')));

            $em->persist($db_transaction);
            $em->flush();
        }
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
                $wallet_id = str_replace('number:','',$data['wallet'])*1;
                $db_wallet = $em->getRepository('Wallet\Entity\Wallet')->findOneById($wallet_id);

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

            $db_first_cycle = $em->getRepository('Cycle\Entity\Cycle')->findOneByStatus(1);
            if($db_first_cycle){
                $db_contract->setFirstCycle($db_first_cycle);
            }

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

    /**
     * Calcula o rendimento dos planos passado como parametro post
     * O calculo é efetuado somando todas as transações relacionadas
     * a aquele aporte - as transações de debito que é diluida entre todas transações de credito
     * ou seja Ex. C - (D / [C + C + C + C + C]).
     */
    public function balanceAction() {
        $em = $this->getEm();
        $request = $this->getRequest();
        $ids = [];
        if($request->isPost()) {
            $data = $request->getPost()->toArray();

            if(!isset($data['ids']) && empty($data['ids']))
            {
                echo json_encode([]);
                die;
            }

            /**
             * @var \UserPlan\Entity\UserPlan[] $db_user_plans
             * @var UserPlan $service
             */

            foreach ($data['ids'] as $id){
                $ids[] = $id['id'];
            }

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

    public function comissionAction() {

        $em = $this->getEm();
        $request = $this->getRequest();

        if($request->isPost()) {
            $data = $request->getPost()->toArray();

            $extract = array();

            $db_patrocinador = $em->getRepository('Register\Entity\User')->findOneById($data['id_patrocinador']);

            if(isset($data['id_indicado']) && $data['id_indicado'] != ''){
                $db_user_plans = $em->getRepository('UserPlan\Entity\UserPlan')->findByUser($data['id_indicado']);

                if(!empty($db_user_plans)){
                    $count = 0;
                    foreach($db_user_plans as $db_user_plan)
                    {
                        $extract['comissions'][$count] = array(
                            'user_plan' => $db_user_plan->getId(),
                            'value' => 0
                        );

                        $db_transactions = $em->getRepository('Transaction\Entity\Transaction')->findBy(array(
                            'user' => $db_patrocinador->getId(),
                            'user_plan' => $db_user_plan->getId()
                        ));

                        if(!empty($db_transactions)){
                            foreach($db_transactions as $db_transaction)
                            {
                                $db_transaction->getValue();

                                $extract['comissions'][$count]['value'] +=  $db_transaction->getValue();
                            }
                        }
                        $count++;
                    }
                }
            }else{
                $db_indicados = $em->getRepository('Register\Entity\User')->findBySponsor($db_patrocinador);
                if(!empty($db_indicados)){
                    $count = 0;
                    foreach( $db_indicados as $db_indicado){
                        $db_user_plans = $em->getRepository('UserPlan\Entity\UserPlan')->findByUser($db_indicado);

                        if(!empty($db_user_plans)){
                            foreach($db_user_plans as $db_user_plan)
                            {
                                $extract['comissions'][$count] = array(
                                    'user_plan' => $db_user_plan->getId(),
                                    'value' => 0
                                );

                                $db_transactions = $em->getRepository('Transaction\Entity\Transaction')->findBy(array(
                                    'user' => $db_patrocinador->getId(),
                                    'user_plan' => $db_user_plan->getId()
                                ));

                                if(!empty($db_transactions)){
                                    foreach($db_transactions as $db_transaction)
                                    {
                                        $db_transaction->getValue();

                                        $extract['comissions'][$count]['value'] +=  $db_transaction->getValue();
                                    }
                                }
                                $count++;
                            }
                        }
                    }
                }
            }

            /**
             * @var UserPlan $service
             */
            $service = $this->getServiceLocator()->get("UserPlan/Service/UserPlan");

            $tots = $service->getTots($db_patrocinador);

            $tot_debito     = $tots['tot_debito'];
            $tot_credito    = $tots['tot_credito'];

            $debito = 0;
            if(!empty($extract['comissions'])){
                foreach($extract['comissions'] as $comission){
                    $debito += $service->debitoDiluido($tot_debito,$tot_credito,$comission['value']);
                }
            }

            $extract['debito'] = $debito;


            echo json_encode($extract);
            die;
        }
    }

    public function sendCashOutAction(){
        $em = $this->getEm();
        $request = $this->getRequest();
        if($request->isPost()) {
            $data = $request->getPost()->toArray();

            $value = $data['value'];

            $receive_method = $data['receive_method'];

            $account = $data['account'];
            $wallet = $data['wallet'];

            $user_id = $data['user_id'];
            $db_user = $em->getRepository('Register\Entity\User')->findOneById($user_id);

            $db_account = $em->getRepository('Account\Entity\Account')->findOneById($account);
            $db_wallet = $em->getRepository('Wallet\Entity\Wallet')->findOneById($wallet);

            $type = 0;

            $db_cycle_active = $em->getRepository('Cycle\Entity\Cycle')->findOneByStatus(1);

            if(!$db_cycle_active)
            {
                throw new \Exception('Não existe ciclo ativo');
            }
            /**
             * @var Solicitation $db_solicitation
             */
            $db_solicitation = $em->getRepository('Solicitation\Entity\Solicitation')->findOneBy(array(
                'type'      => $type,
                'closed'    => 0,
                'cycle'     => $db_cycle_active,
                'user' => $db_user
            ));

            $msg = 'Solicitação efetuada com sucesso!';
            if($db_solicitation){
                $msg = 'Há uma solicitação ainda não atendida!';
                $db_solicitation->setValue($value);
                $db_solicitation->setReceiveMethod($receive_method);
                $db_solicitation->setUser($db_user);
                $db_solicitation->setWallet($db_wallet);

                $em->persist($db_solicitation);
                $em->flush();
            }else{
                $db_solicitation = new Solicitation();
                $db_solicitation->setValue($value);
                $db_solicitation->setType($type);
                $db_solicitation->setUser($db_user);
                $db_solicitation->setWallet($db_wallet);
                $db_solicitation->setAccount($db_account);
                $db_solicitation->setClosed(0);
                $db_solicitation->setCycle($db_cycle_active);
                $db_solicitation->setReceiveMethod($receive_method);

                $em->persist($db_solicitation);
                $em->flush();

                /**
                 * @var UserPlan $service
                 */
                $service = $this->getServiceLocator()->get("UserPlan/Service/UserPlan");
                $rota = $_SERVER['REQUEST_SCHEME'].'://'.$_SERVER['SERVER_NAME'].$this->url()->fromRoute('cash-out-panel',array('id' => $db_solicitation->getId()));

                $result = $service->sendWithdrawal($db_solicitation,$rota);

                if(!$result['result']){
                    echo json_encode(array('result' => false,'message' => 'Houve erro ao notificar o administrador, entre em contato conosco.'));
                    die;
                }
            }

            echo json_encode(array('result' => true,'message' => $msg));
            die;
        }
    }

    public function sendRrAction(){
        $em = $this->getEm();
        $request = $this->getRequest();
        if($request->isPost()) {
            $data = $request->getPost()->toArray();
            $user_plan_id = $data['user_plan_id'];
            $value = $data['value'];
            $renovar = $data['renew'];
            $resgatar = $data['cash_out'];
            $receive_method = $data['receive_method'];

            $account = $data['account'];
            $wallet = $data['wallet'];

            /**
             * @var \UserPlan\Entity\UserPlan $db_user_plan
             */
            $db_user_plan = $em->getRepository('UserPlan\Entity\UserPlan')->findOneById($user_plan_id);
            $db_user = $db_user_plan->getUser();

            $db_account = $em->getRepository('Account\Entity\Account')->findOneById($account);
            $db_wallet = $em->getRepository('Wallet\Entity\Wallet')->findOneById($wallet);

            if($db_account){
                $db_user_plan->setAccount($db_account);
            }

            if($db_wallet){
                $db_user_plan->setWallet($db_wallet);
            }

            $em->persist($db_user_plan);
            $em->flush();

            $type = 0;
            if($renovar != "false"){
                $type = 1;
            }

            if($resgatar != "false"){
                $type = 2;
            }

            /**
             * @var Solicitation $db_solicitation
             */
            $db_solicitation = $em->getRepository('Solicitation\Entity\Solicitation')->findOneBy(array(
                'user_plan' => $db_user_plan,
                'type'      => $type,
                'closed'    => 0
            ));

            $msg = 'Solicitação efetuada com sucesso!';
            if($db_solicitation){
                $msg = 'Há uma solicitação ainda não atendida!';
                $db_solicitation->setValue($value);
                $db_solicitation->setReceiveMethod($receive_method);

                $em->persist($db_solicitation);
                $em->flush();
            }else{
                $db_solicitation = new Solicitation();
                $db_solicitation->setValue($value);
                $db_solicitation->setType($type);
                $db_solicitation->setUser($db_user);
                $db_solicitation->setUserPlan($db_user_plan);
                $db_solicitation->setClosed(0);
                $db_solicitation->setReceiveMethod($receive_method);

                $em->persist($db_solicitation);
                $em->flush();

                /**
                 * @var UserPlan $service
                 */
                $service = $this->getServiceLocator()->get("UserPlan/Service/UserPlan");
                $rota = $_SERVER['REQUEST_SCHEME'].'://'.$_SERVER['SERVER_NAME'].$this->url()->fromRoute('cash-out-panel',array('id' => $db_solicitation->getId()));

                $result = $service->sendWithdrawal($db_solicitation,$rota);

                if(!$result['result']){
                    echo json_encode(array('result' => false,'message' => 'Houve erro ao notificar o administrador, entre em contato conosco.'));
                    die;
                }
            }

            echo json_encode(array('result' => true,'message' => $msg));
            die;
        }
    }

    public function cashOutPanelAction() {
        $em = $this->getEm();

        /**
         * @var Solicitation $db_solicitation
         */
        $db_solicitation_id = $this->params()->fromRoute('id',0);
        $db_solicitation = $em->getRepository('Solicitation\Entity\Solicitation')->findOneById($db_solicitation_id);
        $db_user = $db_solicitation->getUser();

        /**
         * @var \UserPlan\Entity\UserPlan $db_user_plan
         */
        $db_user_plan = $db_solicitation->getUserPlan();

        if($db_user_plan){
            /** O usuário é diferente do dono do aporte **/
            if($db_solicitation->getUserPlan()->getUser()->getId() != $db_user->getId()){

                $db_account = $em->getRepository('Account\Entity\Account')->findOneBy(array(
                    'user' => $db_user
                ),array(
                    'main' => 'DESC'
                ));

                $db_wallet = $em->getRepository('Wallet\Entity\Wallet')->findOneBy(array(
                    'user' => $db_user
                ));
            }else{
                $db_account = $db_user_plan->getAccount();
                $db_wallet = $db_user_plan->getWallet();
            }
        }else{

            if($db_solicitation->getWallet()){
                $db_wallet = $db_user_plan->getWallet();
            }else{
                $db_wallet = $em->getRepository('Wallet\Entity\Wallet')->findOneBy(array(
                    'user' => $db_user
                ));
            }

            if($db_solicitation->getAccount()){
                $db_account = $db_user_plan->getAccount();
            }else{
                $db_account = $em->getRepository('Account\Entity\Account')->findOneBy(array(
                    'user' => $db_user
                ),array(
                    'main' => 'DESC'
                ));
            }

        }

        $db_cycles = $em->getRepository('Cycle\Entity\Cycle')->findByStatus(1);

        //$request = $this->getRequest();
        return new ViewModel(array(
            'db_solicitation'   =>  $db_solicitation,
            'db_user_plan'      =>  $db_user_plan,
            'db_account'        =>  $db_account,
            'db_wallet'         =>  $db_wallet,
            'db_user'           =>  $db_user,
            'db_cycles'         =>  $db_cycles
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
            $db_user = $db_solicitation->getUser();
            switch ($db_solicitation->getType()){
                case 3:
                    $db_cycle = $db_solicitation->getUserPlan()->getFirstCycle();
                    break;
                default:
                    if(isset($data['cycle'])){
                        $db_cycle = $em->getRepository('Cycle\Entity\Cycle')->findOneById($data['cycle']);
                    }
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
            $db_transaction->setUser($db_user);
            $db_transaction->setValue($value);
            $db_transaction->setType(1);//Débito
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
                'user_plan' => $db_user_plan,
                'user'  => $db_user_plan->getUser()
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

    public function userNetworkAction() {

        return new ViewModel(array());
    }

    /**
     * @param \UserPlan\Entity\UserPlan|null $db_user_plan
     * @throws \Exception
     *
     */
    public function applyBalanceAction($db_user_plan = null,$cycle = null) {
        $this->layout()->setTemplate('layout/admin_auth.phtml');
        date_default_timezone_set("America/Sao_Paulo");
        setlocale(LC_ALL, 'pt_BR');

        if($db_user_plan){
            $approved_date = $db_user_plan->getApprovedDate();
            if($approved_date){
                $hour   = $approved_date->format('H');
                $day    = $approved_date->format('d');
                $month  = $approved_date->format('m');
                $year   = $approved_date->format('Y');
            }else{
                throw new \Exception("Erro, aporte (id=" . $db_user_plan->getId() . ") sem data de aprovação ");
                die;
            }
        }else{
            $hour   = date('H');
            $day    = date('d');
            $month  = date('m');
            $year   = date('Y');
        }

        /**
         * @var ZF\ContentNegotiation\Request $request
         */
        $em = $this->getEm();

        /**
         * @var Cycle $db_cycle
         * @var \UserPlan\Entity\UserPlan[] $db_user_plans
         * @var Transaction $db_transaction
         * @var PercentGain $db_percent_gain
         */

        $db_category_transaction = $em
            ->getRepository('CategoryTransaction\Entity\CategoryTransaction')
            ->findOneByCode('rendimento');

        /** Se vier Aporte no parametro  **/
        if($db_user_plan){
            $db_user_plans[] = $db_user_plan;
        }else{
            /** Buscar todos os aportes ativos **/
            $db_user_plans = $em->getRepository('UserPlan\Entity\UserPlan')->findBy(array(
                'status' => 1
            ), array(
                'user' => 'ASC'
            ));
        }

        /** Se vier o cicle no parametro **/
        if($cycle){
            $db_cycle = $em->getRepository('Cycle\Entity\Cycle')->findOneBy(array(
               'month' =>  $cycle['month'],
                'year' => $cycle['year']
            ));

            if($db_cycle == null){
                $db_cycle = new Cycle();
                $db_cycle->setYear($cycle['year']);
                $db_cycle->setMonth($cycle['month']);
                $db_cycle->setStatus(2);
                $em->persist($db_cycle);
                $em->flush();
            }

        }else{
            /** Buscar um ciclo ativo, se não existir, criar **/
            $db_cycle = $em->getRepository('Cycle\Entity\Cycle')->findOneByStatus(1);
        }

        /** Já deixar criado um próximo ciclo pendente **/
        /** Isso se não tiver o parametro ciclo, pode ser um ciclo passado **/
        if($db_cycle && !$cycle){

            if($db_cycle->getMonth() == 12){
                $next_month = 1;
                $next_year = $db_cycle->getYear()+1;
            }else{
                $next_month = $db_cycle->getMonth() + 1;
                $next_year = $db_cycle->getYear();
            }

            $db_next_cycle = $em->getRepository('Cycle\Entity\Cycle')->findOneBy(array(
                'month' => $next_month,
                'year' => $next_year
            ));

            if(!$db_next_cycle){
                /** Criando o próximo ciclo **/
                $db_next_cycle = new Cycle();
                $db_next_cycle->setStatus(0);
                $db_next_cycle->setMonth($next_month);
                $db_next_cycle->setYear($next_year);

                $em->persist($db_next_cycle);
                $em->flush();
            }
        }

        /** Buscar o proximo ciclo inativo e depois transformar em ativo **/
        if(!$db_cycle && date('d') == 1){
            $db_cycle = $em->getRepository('Cycle\Entity\Cycle')->findOneBy(array(
                'status' => 0
            ),array(
                'year' => 'DESC',
                'month' => 'DESC'
            ));

            if($db_cycle){
                $db_cycle->setStatus(1);
                $em->persist($db_cycle);
                $em->flush();
            }
        }

        /** Caso não tenha ciclo ativo e nem inativo **/
        /** CRIAR OUTRO CICLO SOMENTE SE FOR DIA 1º DE CADA MES **/
        if(!$db_cycle && $day == 1){

            /** BUSCAR O ÚLTIMO CICLO FINALIZADO **/
            $last_cycle = $em->getRepository('Cycle\Entity\Cycle')
                ->findOneBy(array(
                    'status' => 2
                ),array(
                    'year' => 'DESC',
                    'month' => 'DESC'
                ));

            /** SE NÃO EXISTIR CICLO ALGUM **/
            if(!$last_cycle){
                $db_cycle = new Cycle();
                $db_cycle->setStatus(1);
                $db_cycle->setMonth($month * 1);
                $db_cycle->getYear($year * 1);

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

        if(!$db_cycle){
            throw new \Exception('Não existe ciclo ativo, e também não é o primeiro dia do mes para criar um ciclo novo.');
            die;
        }

        if(!empty($db_user_plans)){
            $db_user = null;
            $percent = 0;

            foreach ($db_user_plans as $db_user_plan)
            {
                /** Verificar se o primeiro ciclo do aporte é igual ou maior que o aporte ativo **/
                $plan_first_month = $db_user_plan->getFirstCycle()->getMonth();
                $plan_first_year = $db_user_plan->getFirstCycle()->getYear();

                /**
                 * Ex:
                 * Primeiro ciclo do aporte 2019 + (1 / 7) = 2026
                 * Ciclo Atual 2019 + (1 / 7) = 2025
                 * Então Continua porque o ciclo do aporte ainda não começou
                 */
                if($plan_first_year + ($plan_first_month / 100) > $db_cycle->getYear() + ($db_cycle->getMonth() / 100)){
                    continue;
                }

                $ultimo_dia = 0;

                if($db_user == null || $db_user->getId() != $db_user_plan->getUser()->getId())
                {
                    $db_user = $db_user_plan->getUser();

                    $db_aportes = $em->getRepository('UserPlan\Entity\UserPlan')->findByUser($db_user);
                    if(!empty($db_aportes)){
                        $sum_prices = 0;
                        foreach ($db_aportes as $db_aporte)
                        {
                            $sum_prices += $db_aporte->getPlan()->getPrice();
                        }

                        $db_percent_gain = $em->getRepository('PercentGain\Entity\PercentGain')->findOneByInterval($sum_prices);

                        /** Obter o total de horas que ja foram no mes atual **/
                        /** SE o Ciclo for ativo */
                        /** Pegando o total de dias no mês **/
                        $mes = $month; // Mês desejado, pode ser por ser obtido por POST, GET, etc.
                        $ano = $year; // Ano atual
                        $ultimo_dia = date("t", mktime(0,0,0,$mes,'01',$ano)); // Mágica, plim!

                        /** Pegando o total de horas no mês **/
                        $horas_total_mes = $ultimo_dia * 24;

                        $approved_date = $db_user_plan->getApprovedDate();

                        $day_approved = $approved_date->format('d');
                        $month_approved = $approved_date->format('m');
                        $year_approved = $approved_date->format('Y');

                        $horas_a_remover = 0;
                        /** Se a data de aprovação for no mesmo ciclo corrente, retirar as horas que contabilizaram até a hora da aprovação **/

                        if($month_approved == $db_cycle->getMonth() && $year_approved == $db_cycle->getYear()){
                            if($day_approved != 1){
                                //FORMULA ANTIGA
                                //$horas_a_remover = (($day_approved-1)*24) + $approved_date->format('H');
                                //FORMULA NOVA
                                $horas_a_remover = ($day_approved*24) + $approved_date->format('H');
                            }else{
                                $horas_a_remover = $approved_date->format('H');
                            }
                        }

                        /** Obtendo o percentual por hora **/
                        $fracao = $db_percent_gain->getPercent() / $horas_total_mes;
                        $fracao_sponsor = 5 / $horas_total_mes;

                        if($db_cycle->getStatus() == 1){
                            if($day != 1){
                                $horas_total_atual = (($day-1)*24) + $hour;
                            }else{
                                $horas_total_atual = $hour;
                            }
                        }else{
                            $horas_total_atual = $horas_total_mes;
                        }

                        $horas_total_atual -= $horas_a_remover;
                        /** Obter o percentual até a hora corrente **/
                        $percent = $horas_total_atual * $fracao;
                        $percent_sponsor = $horas_total_atual * $fracao_sponsor;
                    }
                }

                /** Finalizando o Ciclo no ultimo dia do mes na ultima hora **/
                /** Se for um ciclo ativo, porque pode ser um ciclo no passado */
                if($ultimo_dia == $day && $hour == 23 && $db_cycle->getStatus() == 1){

                    $db_cycle->setStatus(2);

                    $em->persist($db_cycle);
                    $em->flush();
                }

                /** SALVANDO A TRANSAÇÃO DO DONO DO APORTE **/
                $db_transaction = $em->getRepository('Transaction\Entity\Transaction')->findOneBy(array(
                    'user_plan' =>  $db_user_plan,
                    'cycle'     =>  $db_cycle,
                    'category_transaction' => $db_category_transaction,
                    'user'  => $db_user_plan->getUser()
                ));

                if(!$db_transaction){
                    $db_transaction = new Transaction();
                }

                $db_transaction->setUserPlan($db_user_plan);
                $db_transaction->setUser($db_user_plan->getUser());
                $db_transaction->setCycle($db_cycle);
                $db_transaction->setCategoryTransaction($db_category_transaction);
                $db_transaction->setType(0);

                $value_transaction = $db_user_plan->getPlan()->getPrice() * ($percent / 100);
                $value_transaction_sponsor = $db_user_plan->getPlan()->getPrice() * ($percent_sponsor / 100);

                $db_transaction->setValue($value_transaction);
                $db_transaction->setDate((new \DateTime('now')));

                $em->persist($db_transaction);
                $em->flush();

                $db_category_transaction_sponsor = $em
                    ->getRepository('CategoryTransaction\Entity\CategoryTransaction')
                    ->findOneBy(array(
                        'code' => 'comissao'
                    ));

                if($db_category_transaction_sponsor && $db_user->getSponsor()){
                    /** SE HOUVE A MUDANÇA DE PATROCINADOR, DELETAR AS TRANSAÇÕES DO PATROCINADOR ERRADO **/
                    /**
                     * @var Transaction[] $db_transactions_para_deletar
                     */
                    $db_transactions_para_deletar = $em
                        ->getRepository('Transaction\Entity\Transaction')
                        ->findBy(array(
                            'user_plan' => $db_user_plan,
                            'cycle' => $db_cycle
                        ));

                    if(!empty($db_transactions_para_deletar)){
                        foreach ($db_transactions_para_deletar as $db_transaction_para_deletar){
                            if($db_transaction_para_deletar->getUser()->getId() != $db_user->getId() && $db_transaction_para_deletar->getUser()->getId() != $db_user->getSponsor()->getId()){
                                $em->remove($db_transaction_para_deletar);
                                $em->flush();
                            }
                        }
                    }

                    $db_transaction_sponsor = $em
                        ->getRepository('Transaction\Entity\Transaction')
                        ->findOneBy(array(
                            'user_plan' => $db_user_plan,
                            'user' => $db_user->getSponsor(),
                            'cycle' => $db_cycle,
                            'category_transaction' => $db_category_transaction_sponsor,
                            'type' => 0
                        ));

                    if(!$db_transaction_sponsor){
                        $db_transaction_sponsor = new Transaction();
                        $db_transaction_sponsor->setUserPlan($db_user_plan);
                        $db_transaction_sponsor->setUser($db_user->getSponsor());
                        $db_transaction_sponsor->setCategoryTransaction($db_category_transaction_sponsor);
                        $db_transaction_sponsor->setCycle($db_cycle);
                        $db_transaction_sponsor->setType(0);
                    }

                    $db_transaction_sponsor->setValue($value_transaction_sponsor);
                    $db_transaction_sponsor->setDate(new \DateTime('now'));

                    $em->persist($db_transaction_sponsor);
                    $em->flush();
                }

                $expitarion_date = $db_user_plan->getExpirationDate();
                $date_now = date('Y-m-d');

                /** Se a data da expiração do aporte for igual a data atual, inativar aporte **/
                if((new \DateTime($date_now)) >= $expitarion_date )
                {
                    $db_user_plan->setStatus(0);
                    $em->persist($db_user_plan);
                    $em->flush();

                    /** NOTIFICAR O USUÁRIO QUE O PLANO EXPIROU**/
                    /**
                     * @var UserPlan $service
                     */
                    $service = $this->getServiceLocator()->get("UserPlan/Service/UserPlan");
                    $rota = $_SERVER['REQUEST_SCHEME'].'://'.$_SERVER['SERVER_NAME'].$this->url()->fromRoute('user-auth');
                    //$result = $service->notificaExpiration($db_user_plan,$rota);
                }
            }
        }

        if($db_cycle->getStatus() == 1){
            header("HTTP/1.1 200 OK");
            return true;
        }else{
            return true;
        }
    }

    public function saveUserPlanAction() {
        $em = $this->getEm();
        $request = $this->getRequest();
        if($request->isPost()) {
            $data = $request->getPost()->toArray();

            /**
             * @var \UserPlan\Entity\UserPlan $db_user_plan
             * @var User $db_user
             * @var Plan $db_plan
             * @var Cycle $db_cycle
             * @var Cycle $db_cycle_active
             */

            $db_user = $em->getRepository('Register\Entity\User')->findOneById($data['user']);
            $db_plan = $em->getRepository('Plan\Entity\Plan')->findOneById($data['plan']);

            $date_tmp = substr($data['approved_date'], 0, strpos($data['approved_date'], '('));
            $date_tmp = date('Y-m-d h:i:s', strtotime($date_tmp));
            $approved_date = new \DateTime($date_tmp);

            $db_cycle = $em->getRepository('Cycle\Entity\Cycle')->findOneBy(array(
                'month' => $approved_date->format('m') * 1,
                'year' => $approved_date->format('Y') * 1
            ));

            if(!$db_cycle){
                $db_cycle = new Cycle();
                $db_cycle->setMonth($approved_date->format('m') * 1);
                $db_cycle->setYear($approved_date->format('Y') * 1);
                $db_cycle->setStatus(2);

                $em->persist($db_cycle);
                $em->flush();
            }

            $db_payment_method = $em->getRepository('PaymentMethod\Entity\PaymentMethod')->findOneBy(array(
                "friendly_url" => "bitcoin"
            ));

            if(isset($data['id']) && $data['id'] != ''){
                $db_user_plan = $em->getRepository('UserPlan\Entity\UserPlan')->findOneById($data['id']);
            }else{
                $db_user_plan = new \UserPlan\Entity\UserPlan();
            }

            $db_user_plan->setFirstCycle($db_cycle);
            $db_user_plan->setUser($db_user);
            $db_user_plan->setApprovedDate($approved_date);
            $db_user_plan->setPlan($db_plan);
            $db_user_plan->setCreatedAt((new \DateTime('now')));
            $db_user_plan->setStatus(1);
            $db_user_plan->setPaymentMethod($db_payment_method);

            $em->persist($db_user_plan);
            $em->flush();

            $this->payBonus($db_user_plan,$db_cycle);

            if($db_user_plan->getApprovedDate() != null){
                $db_cycle_active = $em->getRepository('Cycle\Entity\Cycle')->findOneByStatus(1);

                $cp = $db_cycle->getYear() + ($db_cycle->getMonth() / 100);
                $ca = $db_cycle_active->getYear() + ($db_cycle_active->getMonth() / 100);

                /** Se o ciclo do aporte for menor que o ciclo ativo **/
                /** Então será feito calculo de rendimento do ciclo do aporte até o ciclo ativo **/
                /** Efetuar também o pagamento do bonus + Rendimento se o cliente tiver um patrocinador**/
                if($cp < $ca){
                    $db_temp_cycle = array('month' => $db_cycle->getMonth(),'year' => $db_cycle->getYear());

                    while($cp <= $ca){
                        /** APLICACAR O RENDIMENTO AQUI **/
                        $this->applyBalanceAction($db_user_plan,$db_temp_cycle);
                        /** FIM DOS CALCULOS **/

                        if($db_temp_cycle['month'] == 12){
                            $db_temp_cycle['month'] = 1;
                            $db_temp_cycle['year'] += 1;
                        }else{
                            $db_temp_cycle['month'] += 1;
                        }

                        $cp = $db_temp_cycle['year'] + ($db_temp_cycle['month'] / 100);
                    }

                }else{
                    $db_temp_cycle = array('month' => $db_cycle->getMonth(),'year' => $db_cycle->getYear());
                    $this->applyBalanceAction($db_user_plan,$db_temp_cycle);
                }
            }



            echo json_encode(array('result' => true));
            die;
        }
        return new ViewModel(array());
    }

    public function payRapidAction() {
        $em = $this->getEm();
        /**
         * @var BaseFunctions $base
         */
        $base = new BaseFunctions();

        $request = $this->getRequest();

        if($request->isPost()){
            $data = $request->getPost()->toArray();

            if(!empty($data)){

                $db_cycle = $em->getRepository('Cycle\Entity\Cycle')->findOneByStatus(1);
                $db_category_transaction = $em->getRepository('CategoryTransaction\Entity\CategoryTransaction')->findOneByCode('saque');

                if(!$db_cycle){
                    echo "Não tem ciclo ativo";
                    die;
                }

                foreach($data as $k => $v)
                {
                    if(strstr($k,'user_')){
                        $user_id = str_replace('user_','',$k);

                        if($v > 0){
                            $db_user = $em->getRepository('Register\Entity\User')->findOneById($user_id);

                            /**
                             * @var Transaction $db_transaction
                             */
                            $db_transaction = $em->getRepository('Transaction\Entity\Transaction')->findOneBy(array(
                                'user' => $db_user,
                                'cycle' => $db_cycle,
                                'type' => 1
                            ));

                            if(!$db_transaction){
                                $db_transaction = new Transaction();
                            }

                            $db_transaction->setCycle($db_cycle);
                            $db_transaction->setUser($db_user);
                            $db_transaction->setDate(new \DateTime('now'));
                            $db_transaction->setType(1);
                            $db_transaction->setCategoryTransaction($db_category_transaction);
                            $db_transaction->setValue($base->moedaToFloat($v));

                            $em->persist($db_transaction);
                            $em->flush();
                        }
                    }
                }
            }
        }

        return new ViewModel(array('em' => $em));
    }

    public function readXlsAction() {
        $this->layout()->setTemplate('layout/admin_auth.phtml');
        $fileName = 'public/relatorio_cadastros_2019-07-23.xls';
        $excelReader = PHPExcel_IOFactory::createReaderForFile($fileName);
        $excelObj = $excelReader->load($fileName);
        $excelObj->getActiveSheet()->toArray(null, true,true,true);
        $worksheetNames = $excelObj->getSheetNames($fileName);
        foreach($worksheetNames as $key => $sheetName){
            //define a aba ativa
            $excelObj->setActiveSheetIndexByName($sheetName);
            //cria um array com o nome da aba como índice
            $return[$sheetName] = $excelObj->getActiveSheet()->toArray(null, true,true,true);
        }

        /**
         * A = Usuário
         * B = Patrocinador
         * C = Plano Atual
         * E = Data da ativação
         */
        $dados = $return['Planilha1'];
        $usuarios = [];
        if(!empty($dados)){
            $count = 0;
            foreach ($dados as $k => $dado){
                if($count == 0){
                    $count++;
                    continue;
                }


                $usuarios[] = array(
                    'usuario' => $dado['A'],
                    'patrocinador' => $dado['B'],
                    'plano' => $dado['C'],
                    'data' => $dado['E']
                );

                var_dump($usuarios);
                die;

            }
        }
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
