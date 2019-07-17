<?php
namespace Register\Auth;

use Zend\Authentication\Adapter\AdapterInterface,
    Zend\Authentication\Result;

use Doctrine\ORM\EntityManager;

class Adapter implements AdapterInterface
{
    protected $em;
    protected $username;
    protected $password;
    
    public function __construct(EntityManager $em){
        $this->em = $em;
    }
    
    public function getUsername() {
        return $this->username;
    }

    public function setUsername($username) {
        $this->username = $username;
    }

    public function getPassword() {
        return $this->password;
    }

    public function setPassword($password) {
        $this->password = $password;
    }

    public function authenticate() 
    {
        $repository = $this->em->getRepository('Register\Entity\User');
        $user = $repository->findByEmailAndPassword($this->getUsername(),$this->getPassword());

        if($user){
            $isAuthActive = $repository->isAuthActive($this->getUsername());
            if($isAuthActive){
                return new Result(Result::SUCCESS, array('user' => $user),array('OK'));
            }else{
                $msg = 'Usuário inativo, por favor confira seu e-mail e ative sua conta ou comunique ao administrador para que seja feita a ativação!';
                return new Result(Result::FAILURE_CREDENTIAL_INVALID, null,array($msg));
            }
        }else
            return new Result(Result::FAILURE_CREDENTIAL_INVALID, null, array());
    }


}
