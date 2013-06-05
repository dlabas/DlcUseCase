<?php
namespace DlcUseCase\Service;

use DlcBase\Service\AbstractEntityService;
use DlcDiagramm\Diagramm\Dependency;
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

    public function deleteAll()
    {
        $this->getMapper()->deleteAll();
    }

    /**
     * Import doku wiki txt files from given directory
     */
    public function importWikiTxtFiles()
    {
        $options          = $this->getOptions();
        $mapper           = $this->getMapper();
        $serviceLocator   = $this->getServiceLocator();
        $categoryMapper   = $serviceLocator->get('dlccategory_category_mapper');
        $categoryMap      = array();
        $priorityService  = $serviceLocator->get('dlcusecase_priority_service');
        $priorityMap      = array();
        $typeService      = $serviceLocator->get('dlcusecase_type_service');
        $typeMap          = array();
        $entityClass      = $mapper->getEntityClass();
        $depClass         = $options->getDependencyEntityClass();
        $objectManager    = $mapper->getObjectManager();
        $simpleProperties = $objectManager->getClassMetadata($entityClass)
                                          ->getFieldNames();

        $categoryService  = $serviceLocator->get('dlccategory_category_service');
        $rootCategoryNode = $categoryService->getRootCategoryNode($options->getRootCategoryId());

        //Drop existing use cases before importing new use cases?
        if ($options->getDropUseCasesBeforeImport()) {
            $this->deleteAll();
        }

        $dir = $options->getUseCaseDokuWikiTxtFilesDir();

        $dokuWikiUrl      = $options->getDokuWikiUrl();
        $dokuWikiIdPrefix = $options->getDokuWikiIdPrefix();

        $excludeFilenames = $options->getExcludeFilenamesFromImport();

        $txtPositions = $options->getTxtImportPositions();

        $entityMap    = array();
        $dependencies = array();

        $objects = new \RecursiveIteratorIterator(new \RecursiveDirectoryIterator($dir), \RecursiveIteratorIterator::SELF_FIRST);
        foreach ($objects as $name => $object) {
            if ($object->isFile() && $object->getExtension() == 'txt' && !in_array($object->getFilename(), $excludeFilenames)) {

                $entity = new $entityClass();

                $dokuWikiId = $dokuWikiIdPrefix . str_replace('/', ':', substr($name, strlen($dir), -4));

                $entityMap[$dokuWikiId] = $entity;

                $dokuWikiLink = $dokuWikiUrl . '?id=' . $dokuWikiId;

                $entity->setLink($dokuWikiLink);

                $contents = file_get_contents($name);

                foreach ($txtPositions as $property => $positions) {
                    //Start position
                    $start = strpos($contents, $positions['start']) + strlen($positions['start']);
                    //End position
                    if (null === $positions['end']) {
                        $end = strlen($contents);
                    } else {
                        $end = strpos($contents, $positions['end'])-$start;
                    }

                    $value = substr($contents, $start, $end);

                    if (isset($positions['replace']) && is_array($positions['replace'])) {
                        $value = str_replace($positions['replace']['search'], $positions['replace']['replace'], $value);
                    }

                    if (isset($positions['trim']) && $positions['trim'] === true) {
                        $value = trim($value);
                    }

                    if (in_array($property, $simpleProperties)) {
                        $entity->$property = $value;
                    } elseif ($property == 'type') {
                        if (!array_key_exists($value, $typeMap)) {
                            $typeMap[$value] = $typeService->findOneByName($value);
                        }
                        $entity->setType($typeMap[$value]);
                    } elseif ($property == 'category') {
                        if (!array_key_exists($value, $categoryMap)) {
                            $categoryMap[$value] = $categoryMapper->findOneByTitle($value);

                            //If no categpry was found
                            if (null === $categoryMap[$value]) {
                                //Create new category
                                $category = new \DlcCategory\Entity\Category();
                                $category->setName(strtolower($value))
                                         ->setTitle($value)
                                         ->setDescription('Desc of ' . $value)
                                         ->setThumbnail('/img/no_thumbnail.png');

                                $categoryNode = $rootCategoryNode->addChild($category);

                                $categoryMap[$value] = $category;
                            }
                        }
                        $entity->setCategory($categoryMap[$value]);
                    } elseif ($property == 'priority') {
                        if (strlen($value) < 1) {
                            $value = 'Normal';
                        }
                        if (!array_key_exists($value, $priorityMap)) {
                            $priorityMap[$value] = $priorityService->findOneByName($value);
                        }
                        $entity->setPriority($priorityMap[$value]);
                    } elseif ($property == 'dependencies') {
                        if (preg_match_all('/[a-zA-Z0-9\-\_\:äöüÄÖÜ\ ]+/', $value, $matches)) {
                            $dependencies[$dokuWikiId] = $matches[0];
                        } else {
                            $dependencies[$dokuWikiId] = array();
                        }

                    } else {
                        \Zend\Debug\Debug::dump($value, $property);
                    }
                }

                $objectManager->persist($entity);
            }

        }

        //Add all dependencies
        foreach ($dependencies as $wikiId => $dependencies) {
            if (isset($entityMap[$wikiId])) {
                foreach ($dependencies as $dependencyId) {
                    if (isset($entityMap[$dependencyId])) {
                        $dependency = new $depClass();
                        $dependency->from($entityMap[$wikiId])
                                   ->setType(Dependency::TYPE_ASSOCIATION)
                                   ->to($entityMap[$dependencyId]);

                        $entityMap[$wikiId]->addDependencies($dependency);
                    }
                }
            }
        }

        $objectManager->flush();
    }
}