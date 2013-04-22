<?php
namespace DlcUseCase\Form;

use DlcUseCase\Form\BasePriority;
use Zend\Form\Element;
use Zend\Form\Form as ZendForm;

class EditUseCase extends BaseUseCase
{
    public function init()
    {
        parent::init();
        
        $this->setLabel('Edit use case');
    }
}