<?php
namespace DlcUseCase\Service;

use DlcBase\Service\AbstractSetupService;
use DoctrineExtensions\NestedSet\Manager as NestedSetManager;
use Zend\Console\ColorInterface as Color;

class Setup extends AbstractSetupService
{
    protected $rootNode;
    
    /**
     *
     * @var NestedSetManager
     */
    protected $nestedSetManager;
    
    /**
     * Getter for $rootNode
     *
     * @return \DoctrineExtensions\NestedSet\NodeWrapper $rootNode
     */
    public function getRootNode()
    {
        return $this->rootNode;
    }

	/**
     * Setter for $rootNode
     *
     * @param  \DoctrineExtensions\NestedSet\NodeWrapper $rootNode
     * @return Setup
     */
    public function setRootNode($rootNode)
    {
        $this->rootNode = $rootNode;
        return $this;
    }

	/**
     * Getter for $nestedSetManager
     *
     * @return \DoctrineExtensions\NestedSet\Manager $nestedSetManager
     */
    public function getNestedSetManager()
    {
        if (!$this->nestedSetManager instanceof NestedSetManager) {
            $this->setNestedSetManager($this->getServiceLocator()->get('dlccategory_nestedset_manager'));
        }
        return $this->nestedSetManager;
    }
    
    /**
     * Setter for $nestedSetManager
     *
     * @param  \DoctrineExtensions\NestedSet\Manager $nestedSetManager
     * @return Setup
     */
    public function setNestedSetManager($nestedSetManager)
    {
        $this->nestedSetManager = $nestedSetManager;
        return $this;
    }
    
    /**
     * Run the module setup
     *
     * This method will be called if the ZFTool setup modules command will be executed.
     */
    public function runSetup()
    {
        if ($this->params->forceIsActive) {
            $this->createRootCategory()
                 ->createDefaultTypes()
                 ->createDefaultPriorities();
        }
        
        if ($this->getParams()->createSampleData) {
            $this->createSampleData();
        }
    }
    
    public function createRootCategory()
    {
        $this->consoleWriteWithIndent('Creating root category...');
        
        $nestedSetManager = $this->getNestedSetManager();
        
        //Create images root node
        $rootCategory = new \DlcCategory\Entity\Category();
        $rootCategory->setName('use-case-root-category')
                     ->setTitle('Use Cases')
                     ->setDescription('The Use Case Root Category is the root category for all use case categories')
                     ->setThumbnail('/img/no_thumbnail.png');
        
        $this->rootNode = $nestedSetManager->createRoot($rootCategory);
        
        $this->consoleWriteLine('done!', Color::GREEN);
        
        return $this;
    }
    
    public function createDefaultTypes()
    {
        $this->consoleWriteWithIndent('Creating default types...');
        
        $service = $this->getServiceLocator()->get('dlcusecase_type_service');

        if(!$service->create(array('name' => 'Business Use Case'), true)) {
            var_dump($service->getAddForm()->getMessages());
        }
        $service->create(array('name' => 'System Use Case'), true);
        
        $this->consoleWriteLine('done!', Color::GREEN);
        
        return $this;
    }
    
    public function createDefaultPriorities()
    {
        $this->consoleWriteWithIndent('Creating default priorities...');
        
        $service = $this->getServiceLocator()->get('dlcusecase_priority_service');
    
        $service->create(array('name' => 'High'), true);
        $service->create(array('name' => 'Normal'), true);
        $service->create(array('name' => 'Low'), true);
        
        $this->consoleWriteLine('done!', Color::GREEN);
        
        return $this;
    }
    
    public function createSampleData()
    {
        $this->createSampleCatgegories();
        
        return $this;
    }
    
    public function createSampleCatgegories()
    {
        $this->consoleWriteWithIndent('Creating sample categories...');
        
        $nestedSetManager = $this->getNestedSetManager();
        $rootNode         = $this->getRootNode();
        
        //Create child node
        $child = new \DlcCategory\Entity\Category();
        $child->setName('use-case-device-category')
              ->setTitle('Device')
              ->setDescription('The Device Category is the a child category of the Use Case Root Category')
              ->setThumbnail('/img/no_thumbnail.png');
        
        $deviceCategoryNode = $rootNode->addChild($child);
        
        //Create child node
        $child = new \DlcCategory\Entity\Category();
        $child->setName('use-case-user-category')
              ->setTitle('User')
              ->setDescription('The User Category is the a child category of the Use Case Root Category')
              ->setThumbnail('/img/no_thumbnail.png');
        
        $userCategoryNode = $rootNode->addChild($child);
        
        //Create child node
        $child = new \DlcCategory\Entity\Category();
        $child->setName('use-case-customer-category')
              ->setTitle('Customer')
              ->setDescription('The Customer Category is the a child category of the Use Case Root Category')
              ->setThumbnail('/img/no_thumbnail.png');
        
        $customerCategoryNode = $rootNode->addChild($child);
        
        $this->consoleWriteLine('done!', Color::GREEN);
        
        return $this;
    }
}