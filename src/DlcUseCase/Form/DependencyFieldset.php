<?php
namespace DlcUseCase\Form;

use DlcBase\Form\AbstractInputFilterProvidingFieldset;
use Zend\Form\Form;

class DependencyFieldset extends AbstractInputFilterProvidingFieldset
{
    public function __construct()
    {
        parent::__construct('DependingOn');
    }
    /**
     * Bind values to the bound object
     *
     * @param array $values
     * @return mixed|void
     */
    public function bindValues(array $values = array())
    {
        if ($values['toNode'] == '') {
            return null;
        }
        
        return parent::bindValues($values);
    }
    
    public function setObject($object)
    {
        parent::setObject($object);
        
        if ($object->getToNode()) {
            $this->get('toNode')->setValue($object->getToNode()->getId());
        }
        
        return $this;
    }
    
    /**
     * (non-PHPdoc)
     * @see \Zend\Form\Element::init()
     */
    public function init()
    {
        parent::init();
        
        $useCaseClass          = $this->getOptions()->getUseCaseEntityClass();
        $dependencyEntityClass = $this->getOptions()->getDependencyEntityClass();
        
        $this->add(array(
            'type' => 'Zend\Form\Element\Hidden',
            'name' => 'id',
            'attributes' => array(
                'value' => null
            ),
            'options' => array(
                'required' => false,
            )
        ));
        
        $this->add(array(
            'type' => 'Zend\Form\Element\Select',
            'name' => 'type',
            'attributes' => array(
                'class'=>'input-large'
            ),
            'options' => array(
                'value_options' => $dependencyEntityClass::getAvailableTypesStatic(),
            ),
        ));
        
        $this->byName['type']->setValue($dependencyEntityClass::TYPE_ASSOCIATION);
        
        $this->add(array(
            'type' => 'DlcDoctrine\Form\Element\ObjectSelect',
            'name' => 'toNode',
            'attributes' => array(
                'class'=>'input-xxlarge'
            ),
            'options' => array(
                'empty_option'   => 'Please choose a dependency',
                'object_manager' => $this->getServiceLocator()->get('dlcusecase_doctrine_em'),
                'target_class'   => $useCaseClass,
                'property'       => 'extendedName',
                'is_method'      => true,
                'find_method'    => array(
                    'name'   => 'findBy',
                    'params' => array(
                        'criteria' => array(),
                        'orderBy' => array('name' => 'ASC'),
                    ),
                ),
            ),
        ));
        
        $hydrator = $this->getServiceLocator()->get('dlcusecase_dependency_hydrator');
        
        $this->setHydrator($hydrator);
        $this->setObject(new $dependencyEntityClass());
    }
    
    /**
     * @return array
     */
    public function getInputFilterSpecification()
    {
        return array(
            'type' => array(
                'required' => false,
            ),
            'toNode' => array(
                'required' => false,
            ),
        );
    }
}