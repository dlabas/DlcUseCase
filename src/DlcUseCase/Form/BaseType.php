<?php
namespace DlcUseCase\Form;

use DlcBase\Form\AbstractForm;
use Zend\InputFilter\InputFilterProviderInterface;
use Zend\Form\Element;
use Zend\Form\Form as ZendForm;

class BaseType extends AbstractForm implements InputFilterProviderInterface
{
    public function init()
    {
        parent::init();
        
        $this->setLabel('Type');
        
        $this->add(array(
            'type' => 'Zend\Form\Element\Hidden',
            'name' => 'id',
            'attributes' => array(
                'value' => null
            ),
            'options' => array(
                'required' => true,
            )
        ));
        
        $this->add(array(
            'type' => 'Zend\Form\Element\Text',
            'name' => 'name',
            'options' => array(
                'label' => 'Name',
            )
        ));
        
        $this->add(array(
            'type' => 'Zend\Form\Element\Submit',
            'name' => 'submit',
            'attributes' => array(
                'type'  => 'submit',
                'value' => 'Save'
            )
        ));
        
        $hydrator = $this->getServiceLocator()->get('dlcusecase_type_hydrator');
        $this->setHydrator($hydrator);
    }
    
    public function getInputFilterSpecification()
    {
        return array(
            'name' => array(
             'required' => true,
                'filters'  => array(
                    array('name' => 'Zend\Filter\StringTrim'),
                ),
                'validators' => array(
                    new \Zend\Validator\Regex('/^[a-zA-Z0-9\-\s]{3,}$/'),
                ),
            ),
        );
    }
}