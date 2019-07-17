<?php
namespace Wallet\Service;

use Base\Service\AbstractService;

class Wallet extends AbstractService{
    public function __construct(\Doctrine\ORM\EntityManager $em) {
        parent::__construct($em);
        $this->entity = 'Wallet\Entity\Wallet';
    }
}


























?>
