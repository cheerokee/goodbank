<?php
namespace PaymentMethod\Service;

use Base\Service\AbstractService;

class PaymentMethod extends AbstractService{
    public function __construct(\Doctrine\ORM\EntityManager $em) {
        parent::__construct($em);
        $this->entity = 'PaymentMethod\Entity\PaymentMethod';
    }
}


























?>
