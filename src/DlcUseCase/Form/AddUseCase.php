<?php
namespace DlcUseCase\Form;

use DlcUseCase\Form\BaseUseCase;
use Zend\Form\Element;
use Zend\Form\Form as ZendForm;

class AddUseCase extends BaseUseCase
{
    public function init()
    {
        parent::init();
    
        $this->setLabel('Add new use case');
    
        $this->remove('id');
        
        $priorityElement = $this->get('priority');
        
        if (null !== $priorityElement) {
            $priorityElement->setValue(2);
        }
    }
}