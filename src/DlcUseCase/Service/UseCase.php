<?php
namespace DlcUseCase\Service;

use DlcDiagramm\Service\Diagramm;

use DlcBase\Service\AbstractEntityService;
use DlcDiagramm\Diagramm\UseCase as UseCaseDiagramm;
use DlcDiagramm\Service\Diagramm as DiagrammService;

class UseCase extends AbstractEntityService
{
    /**
     * 
     * @var DiagrammService
     */
    protected $diagrammService;
    
	/**
     * Getter for $diagrammService
     *
     * @return \DlcDiagramm\Service\Diagramm $diagrammService
     */
    public function getDiagrammService()
    {
        if (!$this->diagrammService instanceof DiagrammService) {
            $this->setDiagrammService($this->getServiceLocator()->get('dlcdiagramm_diagramm_service'));
        }
        return $this->diagrammService;
    }

	/**
     * Setter for $diagrammService
     *
     * @param  \DlcDiagramm\Service\Diagramm $diagrammService
     * @return UseCase
     */
    public function setDiagrammService($diagrammService)
    {
        $this->diagrammService = $diagrammService;
        return $this;
    }
    
    /**
     * createFromForm
     *
     * @param array $data
     * @return \DlcUseCase\Entity\TypeInterface
     * @throws Exception\InvalidArgumentException
     */
    public function create(array $data, $skipCsrfCheck = true)
    {
        $class  = $this->getMapper()->getEntityClass();
        $entity = new $class;
        $form   = $this->getAddForm();
    
        if ($skipCsrfCheck) {
            $form->remove('csrf');
        }
    
        $form->bind($entity);
        $form->setData($data);
    
        if (!$form->isValid()) {
            return false;
        }
        
        //$this->getEventManager()->trigger(__FUNCTION__, $this, array('entity' => $entity, 'form' => $form));
        $this->getMapper()->save($entity);
        //$this->getEventManager()->trigger(__FUNCTION__.'.post', $this, array('entity' => $entity, 'form' => $form));
        
        $this->updateFromNode($entity);
        
        return $entity;
    }
    
    protected function updateFromNode($entity)
    {
        $dependencies = $entity->getDependencies();
        
        $dependency = $dependencies->current();
        while ($dependency) {
            $dependency->setFromNode($entity);
            $dependency = $dependencies->next();
        }
    }

    /**
     * Creates an use case diagramm from all entities
     * 
     * @return UseCaseDiagramm
     */
    public function createUseCaseDiagramm()
    {
        $nodes = $this->findAll();
        
        $diagrammService = $this->getDiagrammService();
        
        return $diagrammService->createDiagrammFromNodes($nodes, UseCaseDiagramm::TYPE_USE_CASE);
    }
    
    /**
     * Updates an entity
     *
     * @param int $id
     * @param array $data
     * @return boolean|\DlcBase\Entity\AbstractEntity
     */
    public function update($id, array $data)
    {
        $this->validateId($id);
    
        $entity = $this->getById($id);
        $form   = $this->getEditForm();
    
        $form->bind($entity);
        $form->setData($data);
    
        if (!$valid = $form->isValid()) {
            return false;
        }
        
        $this->updateFromNode($entity);
    
        $this->getMapper()->save($entity);
    
        return $entity;
    }
}