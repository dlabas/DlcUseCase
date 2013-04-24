<?php
namespace DlcUseCase\Form;

use DlcBase\Form\AbstractForm;
use Zend\InputFilter\InputFilterProviderInterface;
use Zend\Form\Element;
use Zend\Form\Form as ZendForm;

class EditWikiTemplate extends AbstractForm implements InputFilterProviderInterface
{
    public function init()
    {
        parent::init();

        $this->setLabel('Wiki template');

        $this->add(array(
            'type' => 'Zend\Form\Element\Textarea',
            'name' => 'wiki-template',
            'options' => array(
                'label' =>'',// 'Template',
            ),
            'attributes' => array(
                'class' => 'input-block-level',
                'rows'  => 25,
                'value' => file_get_contents($this->getOptions()->getUseCaseDokuWikiTemplate()),
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
    }

    public function getInputFilterSpecification()
    {
        return array(
            'wiki-template' => array(
                'required'   => true,
                'validators' => array(
                    new \Zend\Validator\NotEmpty(),
                ),
            ),
        );
    }
}