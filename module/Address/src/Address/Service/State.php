<?php
namespace Address\Service;

use Base\Service\AbstractService;

class State extends AbstractService{
    public function __construct(\Doctrine\ORM\EntityManager $em) {
        parent::__construct($em);
        $this->entity = 'Address\Entity\State';
    }

    public function insert(array $data)
    {
        $entity = parent::insert($data);
    }

    public function update(array $data)
    {
        $entity = parent::update($data);
    }
}

