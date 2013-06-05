<?php
namespace DlcUseCase\Mapper;

use DlcDoctrine\Mapper\AbstractMapper;

class Type extends AbstractMapper
{
    public function findOneByName($name)
    {
        return $this->getObjectManager()
                    ->getRepository($this->getEntityClass())
                    ->findOneBy(array('name' => $name));
    }
}