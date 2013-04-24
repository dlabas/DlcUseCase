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
        
        $this->initDependencyFieldset();
        
        //Initialize optional fields
        foreach ($this->getOptions()->getOptionalFields() as $fieldName => $fieldLabel) {
            $this->initOptionalField($fieldName, $fieldLabel);
        }
        
        $this->add(array(
            'type' => 'Zend\Form\Element\Submit',
            'name' => 'submit',
            'attributes' => array(
                'type'  => 'submit',
                'value' => 'Save'
            )
        ));
        
        
        
        /*$dependencyFieldset = $this->getServiceLocator()->get('dlcusecase_dependency_fieldset');
        
        $dependenciesCollection = new Element\Collection('dependencies');
        $dependenciesCollection->setLabel('Dependencies')
                               ->setCount(1)
                               ->setTargetElement($dependencyFieldset)
                               ->setShouldCreateTemplate(true)
                               ->setTemplatePlaceholder('__placeholder__');
        
        $this->add($dependenciesCollection);*/
        
        
        $hydrator = $this->getServiceLocator()->get('dlcusecase_usecase_hydrator');
        $this->setHydrator($hydrator);
    }
    
    public function initDependencyFieldset()
    {
        $dependencyFieldset = $this->getServiceLocator()->get('dlcusecase_dependency_fieldset');
        
        $dependenciesCollection = new Element\Collection('dependencies');
        $dependenciesCollection->setLabel('Dependencies')
                               ->setCount(1)
                               ->setTargetElement($dependencyFieldset)
                               ->setShouldCreateTemplate(true)
                               ->setTemplatePlaceholder('__placeholder__');
        
        $this->add($dependenciesCollection);
        
        return $this;
    }
    
    public function initOptionalField($fieldName, $fieldLabel)
    {
        $initMethod = 'initOptional' . ucfirst($fieldName) . 'Field';
        
        if (!method_exists($this, $initMethod)) {
            throw new \InvalidArgumentException('No init method found for field "' . $initMethod . '"');
        }
        
        $this->$initMethod($fieldName, $fieldLabel);
    }
    
    public function initOptionalCategoryField($fieldName, $fieldLabel)
    {
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
                //'property'       => 'recursiveTitle',
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

        return $this;
    }
    
    public function initOptionalPriorityField($fieldName, $fieldLabel)
    {
        $this->add(array(
            'type' => 'DlcDoctrine\Form\Element\ObjectSelect',
            'name' => $fieldName,
            'attributes' => array(
                'class'=>'input-xxlarge'
            ),
            'options' => array(
                'label'          => $fieldLabel,
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
        
        return $this;
    }
    
    public function initOptionalNoteField($fieldName, $fieldLabel)
    {
        $this->initNewTextElement($fieldName, $fieldLabel);
        
        return $this;
    }
    
    public function initOptionalLinkField($fieldName, $fieldLabel)
    {
        $this->initNewTextElement($fieldName, $fieldLabel);
        
        return $this;
    }
    
    public function initOptionalDescriptionField($fieldName, $fieldLabel)
    {
        $this->initNewTextAreaElement($fieldName, $fieldLabel);
        
        return $this;
    }
    
    public function initOptionalDetailsField($fieldName, $fieldLabel)
    {
        $this->initNewTextAreaElement($fieldName, $fieldLabel);
    
        return $this;
    }
    
    public function initOptionalCommentField($fieldName, $fieldLabel)
    {
        $this->initNewTextAreaElement($fieldName, $fieldLabel);
    
        return $this;
    }
    
    public function initOptionalInputDataField($fieldName, $fieldLabel)
    {
        $this->initNewTextAreaElement($fieldName, $fieldLabel);
    
        return $this;
    }
    
    public function initOptionalOutputDataField($fieldName, $fieldLabel)
    {
        $this->initNewTextAreaElement($fieldName, $fieldLabel);
    
        return $this;
    }
    
    public function initNewTextElement($fieldName, $fieldLabel)
    {
        $this->add(array(
            'type' => 'Zend\Form\Element\Text',
            'name' => $fieldName,
            'attributes' => array(
                'class'=>'input-xxlarge'
            ),
            'options' => array(
                'label' => $fieldLabel,
            )
        ));
        
        return $this;
    }
    
    public function initNewTextAreaElement($fieldName, $fieldLabel)
    {
        $this->add(array(
            'type' => 'Zend\Form\Element\Textarea',
            'name' => $fieldName,
            'attributes' => array(
                'class' =>'input-xxlarge',
                'rows'  => 5,
            ),
            'options' => array(
                'label' => $fieldLabel,
            )
        ));
    
        return $this;
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