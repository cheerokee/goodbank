<?php
namespace Bank\Service;

use Base\Service\AbstractService;

class Bank extends AbstractService{
    public function __construct(\Doctrine\ORM\EntityManager $em) {
        parent::__construct($em);
        $this->entity = 'Bank\Entity\Bank';
    }
}


























?>
