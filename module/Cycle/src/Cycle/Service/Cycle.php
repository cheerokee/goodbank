<?php
namespace Cycle\Service;

use Base\Service\AbstractService;

class Cycle extends AbstractService{
    public function __construct(\Doctrine\ORM\EntityManager $em) {
        parent::__construct($em);
        $this->entity = 'Cycle\Entity\Cycle';
    }
}


























?>
