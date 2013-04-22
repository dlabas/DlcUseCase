<?php
namespace DlcUseCase\Form;

use DlcUseCase\Form\BaseType;
use Zend\Form\Element;
use Zend\Form\Form as ZendForm;

class AddType extends BaseType
{
    public function init()
    {
        parent::init();
    
        $this->setLabel('Add new type');
    
        $this->remove('id');
    }
}