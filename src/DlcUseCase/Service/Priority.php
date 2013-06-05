<?php
namespace DlcUseCase\Service;

use DlcBase\Service\AbstractEntityService;

class Priority extends AbstractEntityService
{
    public function findOneByName($name)
    {
        return $this->getMapper()->findOneByName($name);
    }
}