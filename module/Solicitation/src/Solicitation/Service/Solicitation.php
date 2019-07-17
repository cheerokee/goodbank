<?php
namespace Solicitation\Service;

use Base\Service\AbstractService;

class Solicitation extends AbstractService{
    public function __construct(\Doctrine\ORM\EntityManager $em) {
        parent::__construct($em);
        $this->entity = 'Solicitation\Entity\Solicitation';
    }
}


























?>
