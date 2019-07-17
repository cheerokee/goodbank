<?php
namespace Plan\Service;

use Base\Service\AbstractService;

class Plan extends AbstractService{
    public function __construct(\Doctrine\ORM\EntityManager $em) {
        parent::__construct($em);
        $this->entity = 'Plan\Entity\Plan';
    }
}


























?>
