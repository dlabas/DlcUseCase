<?php
namespace DlcUseCase\Form;

use DlcUseCase\Form\BasePriority;
use Zend\Form\Element;
use Zend\Form\Form as ZendForm;
use Zend\Form\FormInterface;

class EditUseCase extends BaseUseCase
{
    public function init()
    {
        parent::init();

        $this->setLabel('Edit use case');
    }

    public function bind($useCase, $flags = FormInterface::VALUES_NORMALIZED)
    {
        parent::bind($useCase, $flags);

        if ($useCase->getType() != null) {
            $this->byName['type']->setValue($useCase->getType()->getId());
        }

        if ($useCase->getCategory() != null) {
            $this->byName['category']->setValue($useCase->getCategory()->getId());
        }

        if ($useCase->getPriority() != null) {
            $this->byName['priority']->setValue($useCase->getPriority()->getId());
        }

        $dependenciesCollection = $this->byName['dependencies'];

        foreach ($dependenciesCollection->getFieldsets() as $fieldset) {
            if ($fieldset->byName['toNode']->getValue() != null) {
                $fieldset->byName['toNode']->setEmptyOption('Delete this dependency');
            }
        }
    }
}