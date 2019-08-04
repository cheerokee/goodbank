<?php
namespace Customer\Form;

use Base\Form\FormBase;
use Doctrine\Common\Collections\Criteria;
use Doctrine\ORM\EntityManager;
use Register\Form\User;
use Register\Form\UserFilter;

class Customer extends User{
    public function __construct(EntityManager  $objectManager) {
        parent::__construct($objectManager);

        $field = new \Zend\Form\Element\Hidden('redirect');
        $field->setValue('/admin/customer');
        $this->add($field);
    }
}
