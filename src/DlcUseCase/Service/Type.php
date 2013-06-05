<?php
namespace DlcUseCase\Service;

use DlcBase\Service\AbstractEntityService;

class Type extends AbstractEntityService
{
    public function findOneByName($name)
    {
        return $this->getMapper()->findOneByName($name);
    }
}