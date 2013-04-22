<?php
namespace DlcUseCase\Form;

use DlcUseCase\Form\BasePriority;
use Zend\Form\Element;
use Zend\Form\Form as ZendForm;

class EditPriority extends BasePriority
{
    public function init()
    {
        parent::init();
        
        $this->setLabel('Edit priority');
    }
}