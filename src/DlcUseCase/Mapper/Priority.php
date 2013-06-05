<?php
namespace DlcUseCase\Mapper;

use DlcDoctrine\Mapper\AbstractMapper;

class Priority extends AbstractMapper
{
    public function findOneByName($name)
    {
        return $this->getObjectManager()
                    ->getRepository($this->getEntityClass())
                    ->findOneBy(array('name' => $name));
    }
}