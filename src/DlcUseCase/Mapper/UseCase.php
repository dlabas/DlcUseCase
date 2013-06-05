<?php
namespace DlcUseCase\Mapper;

use DlcDoctrine\Mapper\AbstractMapper;

class UseCase extends AbstractMapper
{
    public function deleteAll()
    {
        $objectManager = $this->getObjectManager();
        $entities      = $this->findAll();

        foreach ($entities as $entity) {
            $objectManager->remove($entity);
        }

        $objectManager->flush();
    }
}