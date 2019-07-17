<?php
namespace CategoryTransaction\Service;

use Base\Service\AbstractService;

class CategoryTransaction extends AbstractService{
    public function __construct(\Doctrine\ORM\EntityManager $em) {
        parent::__construct($em);
        $this->entity = 'CategoryTransaction\Entity\CategoryTransaction';
    }
}


























?>
