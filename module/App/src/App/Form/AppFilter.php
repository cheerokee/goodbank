<?php

namespace App\Form;

use Zend\InputFilter\InputFilter;

class AppFilter extends InputFilter
{
    
    public function __construct() 
    {
        $this->add(array(
            'name' => 'company',
            'required'=>false
        ));

    }
}
