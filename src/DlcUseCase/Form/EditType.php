<?php
namespace DlcUseCase\Form;

use DlcUseCase\Form\BaseType;
use Zend\Form\Element;
use Zend\Form\Form as ZendForm;

class EditType extends BaseType
{
    public function init()
    {
        parent::init();
        
        $this->setLabel('Edit type');
    }
}