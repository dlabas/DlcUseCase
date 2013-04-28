<?php
namespace DlcUseCase\Form;

use DlcBase\Form\AbstractForm;
use Zend\InputFilter\InputFilterProviderInterface;
use Zend\Form\Element;
use Zend\Form\Form as ZendForm;
use Zend\Form\FormInterface;

class UseCaseFilter extends AbstractForm implements InputFilterProviderInterface
{
    public function init()
    {
        parent::init();

        $this->setLabel('Use Case filter');

        $optionalFields = $this->getOptions()->getOptionalFields();

        $this->add(array(
            'type' => 'DlcDoctrine\Form\Element\ObjectSelect',
            'name' => 'filter[type]',
            'attributes' => array(
                'class'=>'input-large'
            ),
            'options' => array(
                'label'          => 'Type',
                'empty_option'   => 'Please choose a type',
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

        if (isset($optionalFields['category'])) {
            $this->add(array(
                'type' => 'DlcDoctrine\Form\Element\ObjectSelect',
                'name' => 'filter[category]',
                'attributes' => array(
                    'class'=>'input-large'
                ),
                'options' => array(
                    'label'          => $optionalFields['category'],
                    'empty_option'   => 'Please choose a category',
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
        }

        if (isset($optionalFields['priority'])) {
            $this->add(array(
                'type' => 'DlcDoctrine\Form\Element\ObjectSelect',
                'name' => 'filter[priority]',
                'attributes' => array(
                    'class'=>'input-large'
                ),
                'options' => array(
                    'label'          => $optionalFields['priority'],
                    'empty_option'   => 'Please choose a priority',
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
        }

        $this->add(array(
            'type' => 'Zend\Form\Element\Submit',
            'name' => 'submit',
            'attributes' => array(
                'type'  => 'submit',
                'value' => 'Set filter'
            )
        ));
    }

    /**
     * Should return an array specification compatible with
     * {@link Zend\InputFilter\Factory::createInputFilter()}.
     *
     * @return array
     */
    public function getInputFilterSpecification()
    {
        return array(
            'filter[type]' => array(
                'required' => false,
            ),
            'filter[category]' => array(
                'required' => false,
            ),
            'filter[priority]' => array(
                'required' => false,
            )
        );
    }
}