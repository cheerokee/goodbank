<?php

namespace Register\Service;

use Acl\Entity\Role;
use Base\Controller\BaseFunctions;
use Base\Service\AbstractService;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\EntityManager;
use Register\Entity\UserRole;
use Zend\Authentication\AuthenticationService;
use Zend\Session\Storage\SessionStorage;
use Zend\Stdlib\Hydrator;
use Zend\Mail\Transport\Smtp as SmtpTransport;
use Base\Mail\Mail;
use Register\Entity\User as UserEntity;

class User extends AbstractService
{

    protected $transport;
    protected $view;
    protected $configurationMail;
    protected $db_role_fathers = [];
    
    public function __construct(EntityManager $em, SmtpTransport $transport, $view) 
    {
        parent::__construct($em);
        
        $this->entity = 'Register\Entity\User';
        $this->transport = $transport;
        $this->view = $view;
    }

    public function insert(array $data) {
        $data['friendlyUrl'] = $this->functions->strToFriendlyUrl($data['name']);

        $tmp = $this->em->getRepository('Register\Entity\User')->findOneBy(array(
            'friendlyUrl' => $data['friendlyUrl']
        ));

        if($tmp){
            $count_friendly = 1;
            while ($tmp) {
                $data['friendlyUrl'] = $this->functions->strToFriendlyUrl($data['name']) . '-' . $count_friendly;

                $tmp = $this->em->getRepository($this->entity)->findOneBy(array(
                    'friendlyUrl' => $data['friendlyUrl']
                ));
                $count_friendly++;
            }
        }

        $entity = parent::insert($data);

        if($entity)
        {
            $userRole = $this->em->getRepository('Register\Entity\UserRole')->findOneByUser($entity);
            if(!$userRole){
                /**
                 * @var UserRole $userRole
                 * @var Role $role
                 */

                $role = $this->em->getRepository('Acl\Entity\Role')->findOneByName('Cliente');
                if(!$role){
                    $role = new Role();
                    $role->setName('Cliente');
                    $role->setFriendlyUrl('cliente');

                    $this->em->persist($role);
                    $this->em->flush();
                }

                $userRole = new UserRole();
                $userRole->setUser($entity);
                $userRole->setRole($role);

                $this->em->persist($userRole);
                $this->em->flush();
            }

            $return = $this->sendConfirm($data);

            if((isset($return['result']) && $return['result']) || $data['adminForm']){
                return $entity;
            }else{
                return false;
            }
        }
    }

    public function sendConfirm($data){
        /**
         * @var \Register\Entity\User $entity
         */
        $entity = $this->em->getRepository('Register\Entity\User')->findOneByEmail($data['email']);

        if(isset($data['reference']) && $data['reference'] == 'register'){
            $data = array(
                'from'  =>  array(
                    $this->getConfigurationMail()['mail']['connection_config']['from'] =>
                        $this->getConfigurationMail()['mail']['connection_config']['name_from']
                ),
                'to'    =>  array(
                    $entity->getEmail() => $entity->getName()
                ),
                'id'   =>  $entity->getId(),
                'activeKey' =>  $entity->getActivationKey(),
                'name' => $entity->getName(),
                'email' => $entity->getEmail()
            );

            $subject = 'Cadastro efetuado no sistema';
            $return = $this->sendMail($data,$subject,'add-user');
        }else{
            $return['result'] = true;
        }

        return $return;
    }

    public function update(array $data)
    {
        $entity = $this->em->getReference($this->entity, $data['id']);

        $data['friendlyUrl'] = $this->functions->strToFriendlyUrl($data['name']);

        $tmp = $this->em->getRepository('Register\Entity\User')->findOneBy(array(
            'friendlyUrl' => $data['friendlyUrl']
        ));

        if($tmp){
            $count_friendly = 1;
            if($tmp->getId() != $data['id']){
                while ($tmp) {
                    $data['friendlyUrl'] = $this->functions->strToFriendlyUrl($data['name']) . '-' . $count_friendly;

                    $tmp = $this->em->getRepository($this->entity)->findOneBy(array(
                        'friendlyUrl' => $data['friendlyUrl']
                    ));
                    $count_friendly++;
                }
            }
        }

        if(empty($data['password']))
            unset($data['password']);

        (new Hydrator\ClassMethods())->hydrate($data, $entity);
        if($entity->getActive() != null && $entity->getActive() != '') {
            $entity->setActive(1);
        }

        $this->em->persist($entity);
        $this->em->flush();

        return $entity;
    }

    public function activate($key)
    {
        $repo = $this->em->getRepository('Register\Entity\User');

        $user = $repo->findOneByActivationKey($key);

        if($user)
        {
            $user->setActive(true);

            $this->em->persist($user);
            $this->em->flush();

            return $user;
        }else{
            return false;
        }
    }

    public function lostPassword(array $data){

        $db_user = $this->em->getRepository('Register\Entity\User')->findOneByEmail($data['email']);

        if($db_user){
            $novaSenha = $this->geraSenha();

            $db_user->setPassword($novaSenha);

            $this->em->persist($db_user);
            $this->em->flush();

            $data = array(
                'from'  =>  array(
                    $this->getConfigurationMail()['mail']['connection_config']['from'] =>
                        $this->getConfigurationMail()['mail']['connection_config']['name_from']
                ),
                'to'    =>  array(
                    $db_user->getEmail() => $db_user->getName()
                ),
                'name' => $db_user->getName(),
                'senha' => $novaSenha
            );

            $subject = 'Recuperacao de senha';
            $return = $this->sendMail($data,$subject,'mail-lostPassword');

            if($return['result']){
                $return['msg'] = "Sua senha foi recuperada com sucesso, por favor entre na sua caixa de entrada para obter sua nova senha!";
            }

            return $return;
        }else{
            return array(
                'result'    =>  false,
                'msg'       =>  "Usuário não encontrado"
            );
        }
    }

    public function geraSenha($tamanho = 8, $maiusculas = true, $numeros = true, $simbolos = false)
    {
        // Caracteres de cada tipo
        $lmin = 'abcdefghijklmnopqrstuvwxyz';
        $lmai = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $num = '1234567890';
        $simb = '!@#$%*-';
        // Variáveis internas
        $retorno = '';
        $caracteres = '';
        // Agrupamos todos os caracteres que poderão ser utilizados
        $caracteres .= $lmin;
        if ($maiusculas) $caracteres .= $lmai;
        if ($numeros) $caracteres .= $num;
        if ($simbolos) $caracteres .= $simb;
        // Calculamos o total de caracteres possíveis
        $len = strlen($caracteres);
        for ($n = 1; $n <= $tamanho; $n++) {
            // Criamos um número aleatório de 1 até $len para pegar um dos caracteres
            $rand = mt_rand(1, $len);
            // Concatenamos um dos caracteres na variável $retorno
            $retorno .= $caracteres[$rand-1];
        }
        return $retorno;
    }

    public function getByMail($email){
        $db_user = $this->em->getRepository('Register\Entity\User')->findOneByEmail($email);
        return ($db_user instanceof UserEntity)? $db_user : false;
    }

    public function canList($entity,$role_selected = null){

        /**
         * @var \Register\Entity\User[] $db_users
         * @var \Register\Entity\User $db_login
         * @var UserRole[] $user_roles
         */
        /** Listar todos até passar por todas as regras **/
        $db_users = $this->em->getRepository($entity)->findAll();
        $db_login = $this->em->getRepository('Register\Entity\User')->findOneById($_SESSION['User']->storage);

        $user_roles = $db_login->getUserRoles()->getValues();
        if(!empty($user_roles)){
            foreach ($user_roles as $user_role){
                $db_role = $user_role->getRole();

                $this->getRoleFathers($db_role);
            }
        }

        if(!empty($db_users)){
            if($role_selected){
                foreach($db_users as $k => $db_user){
                    if(!$db_user->hasThisRole($role_selected))
                    {
                        unset($db_users[$k]);
                    }
                }
            }else{
                foreach($db_users as $k => $db_user){
                    foreach ($this->getDbRoleFathers() as $father)
                    {
                        if($db_user->hasThisRole($father->getName()) && $db_user->getId() != $db_login->getId())
                        {
                            unset($db_users[$k]);
                        }
                    }
                }
            }
        }

        return $db_users;
    }

    public function getRoleFathers($db_role){
        //Tem Perfis Pai?
        $father_roles = $this->em->getRepository('Acl\Entity\Role')->findByParent($db_role);

        if(!empty($father_roles)){
            if(!empty($this->getDbRoleFathers())){
                $this->setDbRoleFathers(array_merge($this->getDbRoleFathers(),$father_roles));
            }else{
                $this->setDbRoleFathers($father_roles);
            }

            foreach($father_roles as $db_role){
                $this->getRoleFathers($db_role);
            }
        }
    }

    public function getUser($id){
        return $this->em->getRepository('Register\Entity\User')->findOneById($id);
    }

    public function getConfigurationMail()
    {
        return $this->configurationMail;
    }

    public function setConfigurationMail($configurationMail)
    {
        $this->configurationMail = $configurationMail;
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

    /**
     * @return mixed
     */
    public function getDbRoleFathers()
    {
        return $this->db_role_fathers;
    }

    /**
     * @param mixed $db_role_fathers
     */
    public function setDbRoleFathers($db_role_fathers)
    {
        $this->db_role_fathers = $db_role_fathers;
    }

}
