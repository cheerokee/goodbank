<?php
namespace Transaction\Service;

use Base\Service\AbstractService;
use Doctrine\ORM\EntityManager;
use Register\Entity\UserRole;

class Transaction extends AbstractService{

    protected $em;

    public function __construct(EntityManager $em) {
        parent::__construct($em);

        $this->entity = 'Transaction\Entity\Transaction';
    }

    public function canList($entity,$role_selected = null){
        $db_login = $this->em->getRepository('Register\Entity\User')->findOneById($_SESSION['User']->storage);

        $transaction_ids = [];
        if(!$db_login->hasThisRole('administrador') && !$db_login->hasThisRole('funcionario')){
            $db_entities = $this->em->getRepository($entity)->findByUser($db_login->getId());
        }else{
            $db_entities = $this->em->getRepository($entity)->findAll();
        }

        return $db_entities;
    }

}


























?>
