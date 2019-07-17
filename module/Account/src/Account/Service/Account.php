<?php
namespace Account\Service;

use Base\Service\AbstractService;

class Account extends AbstractService{
    public function __construct(\Doctrine\ORM\EntityManager $em) {
        parent::__construct($em);
        $this->entity = 'Account\Entity\Account';
    }
}


























?>
