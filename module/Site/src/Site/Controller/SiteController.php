<?php

namespace Site\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class SiteController extends AbstractActionController{
    public function __construct(){
    }

    public function indexAction(){
        $this->layout()->setTemplate('layout/layout.phtml');

        return new ViewModel(array());
    }
}
