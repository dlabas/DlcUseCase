<?php
namespace DlcUseCase\Service;


use Zend\Paginator\Paginator;

use DlcBase\Service\AbstractEntityService;
use DlcDiagramm\Diagramm\UseCase as UseCaseDiagramm;
use DlcDiagramm\Service\Diagramm;
use DlcDiagramm\Service\Diagramm as DiagrammService;
use DlcUseCase\Entity\UseCase as UseCaseEntity;

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


    protected function generateWikiPageFromTemplate($entities)
    {
        $template = $this->getOptions()->getUseCaseDokuWikiTemplate();

        if ($entities === null || !$template) {
            return;
        } elseif (is_file($template)) {
            $template = file_get_contents($template);
        }

        if (!is_array($entities) && !$entities instanceof Paginator) {
            $entities = array($entities);
        }

        foreach ($entities as $entity) {
            $dependenciesStr = '';

            foreach ($entity->getDependencies() as $dependency) {
                $dependenciesStr .= '  * ' . $dependency->getToNode()->getExtendedName() . PHP_EOL;
            }

            $generatedPage = str_replace(
                array(
                    '#NAME#',
                    '#TYPE#',
                    '#CATEGORY#',
                    '#DESCRIPTION#',
                    '#PRIORITY#',
                    '#DETAILS#',
                    '#COMMENT#',
                    '#INPUT_DATA#',
                    '#OUTPUT_DATA#',
                    '#DEPENDENCIES#',
                ),
                array(
                    $entity->getName(),
                    $entity->getType()->getName(),
                    $entity->getCategoryTitle(),
                    $entity->getDescription(),
                    $entity->getPriorityName(),
                    $entity->getDetails(),
                    $entity->getComment(),
                    $entity->getInputData(),
                    $entity->getOutputData(),
                    $dependenciesStr
                ),
                $template
            );

            $entity->setGeneratedWikiPage($generatedPage);
        }
    }

    /**
     * Returns a list containig all entities
     *
     * @return null|\Doctrine\Common\Collections\ArrayCollection
     */
    public function findAll()
    {
        $entities = parent::findAll();

        $this->generateWikiPageFromTemplate($entities);

        return $entities;
    }

    /**
     * Returns a single entity
     *
     * @param int $id
     */
    public function getById($id)
    {
        $entity = $this->getMapper()->find($id);

        $this->generateWikiPageFromTemplate($entity);

        return $entity;
    }

    /**
     * Returns a pagination object with entities
     *
     * @param int $page
     * @param int $limit
     * @param null|string $query
     * @param null|string $orderBy
     * @param string $sort
     * @return \Zend\Paginator\Paginator
     */
    public function pagination($page, $limit, $query = null, $orderBy = null, $sort = 'ASC')
    {
        $pagination = $this->getMapper()->pagination($page, $limit, $query, $orderBy, $sort);

        $this->generateWikiPageFromTemplate($pagination);

        $e = $this->findAll();

        return $pagination;
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
     * Creates an use case diagramm from an single entity
     *
     * @param int|\DlcUseCase\Entity\UseCase $entity
     * @return UseCaseDiagramm
     */
    public function createUseCaseDiagrammFor($entity)
    {
        if (is_int($entity)) {
            $entity = $this->getById($entity);
        } elseif (!$entity instanceof UseCaseEntity) {
            throw new \InvalidArgumentException('Unkown entity data type "' . gettype($entity) . '"');
        }

        $diagrammService = $this->getDiagrammService();

        return $diagrammService->createDiagrammFromNodes(array($entity), UseCaseDiagramm::TYPE_USE_CASE);
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