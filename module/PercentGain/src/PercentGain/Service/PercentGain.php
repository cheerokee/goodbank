<?php
namespace PercentGain\Service;

use Base\Service\AbstractService;

class PercentGain extends AbstractService{
    public function __construct(\Doctrine\ORM\EntityManager $em) {
        parent::__construct($em);
        $this->entity = 'PercentGain\Entity\PercentGain';
    }
}


























?>
