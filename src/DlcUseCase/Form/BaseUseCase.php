<?php
namespace DlcUseCase\Form;

use DlcBase\Form\AbstractForm;
use Zend\InputFilter\InputFilterProviderInterface;
use Zend\Form\Element;
use Zend\Form\Form as ZendForm;
use Zend\Form\FormInterface;

class BaseUseCase extends AbstractForm implements InputFilterProviderInterface
{
    public function init()
    {
        parent::init();
        
        $this->setLabel('UseCase');
        
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
            'attributes' => array(
                'class'=>'input-xxlarge'
            ),
            'options' => array(
                'label' => 'Name',
            )
        ));
        
        $this->add(array(
            'type' => 'DlcDoctrine\Form\Element\ObjectSelect',
            'name' => 'type',
            'attributes' => array(
                'class'=>'input-xxlarge'
            ),
            'options' => array(
                'label'          => 'Type',
                'object_manager' => $this->getServiceLocator()->get('dlcusecase_doctrine_em'),
                'target_class'   => $this->getOptions()->getTypeEntityClass(),
                'property'       => 'name',
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
        
        $this->add(array(
            'type' => 'DlcDoctrine\Form\Element\ObjectSelect',
            'name' => 'category',
            'attributes' => array(
                'class'=>'input-xxlarge'
            ),
            'options' => array(
                'label'          => 'Category',
                'object_manager' => $this->getServiceLocator()->get('dlcusecase_doctrine_em'),
                'target_class'   => $this->getOptions()->getCategoryEntityClass(),
                'property'       => 'title',
                'is_method'      => true,
                'find_method'    => array(
                    'name'   => 'findBy',
                    'params' => array(
                        'criteria' => array('root' => $this->getOptions()->getRootCategoryId()),
                        'orderBy' => array('name' => 'ASC'),
                    ),
                ),
            ),
        ));
        
        $this->add(array(
            'type' => 'DlcDoctrine\Form\Element\ObjectSelect',
            'name' => 'priority',
            'attributes' => array(
                'class'=>'input-xxlarge'
            ),
            'options' => array(
                'label'         => 'Priority',
                'object_manager' => $this->getServiceLocator()->get('dlcusecase_doctrine_em'),
                'target_class'   => $this->getOptions()->getPriorityEntityClass(),
                'property'       => 'name',
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
        
        $this->add(array(
            'type' => 'Zend\Form\Element\Text',
            'name' => 'link',
            'attributes' => array(
                'class'=>'input-xxlarge'
            ),
            'options' => array(
                'label' => 'Link',
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
        
        $dependencyFieldset = $this->getServiceLocator()->get('dlcusecase_dependency_fieldset');
        
        $dependenciesCollection = new Element\Collection('dependencies');
        $dependenciesCollection->setLabel('Dependencies')
                               ->setCount(1)
                               ->setTargetElement($dependencyFieldset)
                               ->setShouldCreateTemplate(true)
                               ->setTemplatePlaceholder('__placeholder__');
        
        $this->add($dependenciesCollection);
        
        
        $hydrator = $this->getServiceLocator()->get('dlcusecase_usecase_hydrator');
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
            'dependencies' => array(
                'required' => false,
            ),
        );
    }
}