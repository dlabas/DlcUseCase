<?php

namespace DlcUseCase\Options;

use Zend\Stdlib\AbstractOptions;

class ModuleOptions extends AbstractOptions
{
    /**
     * Turn off strict options mode
     */
    protected $__strictMode__ = false;
    
    /**
     * 
     * @var int
     */
    protected $rootCategoryId = 3;
    
    /**
     * Optional use case fields. Will be used in the UseCaseForm and the detail view of an use case
     *  
     * @var array
     */
    protected $optionalFields = array(
        'category'    => 'Category',
        'priority'    => 'Priority',
        'note'        => 'Note',
        'link'        => 'Link',
        'description' => 'Description',
        'details'     => 'Details',
        'comment'     => 'Comment',
        'inputData'   => 'Input data',
        'outputData'  => 'Output data',
    );
    
    /**
     * Should a diagramm be displayed in the detail view of an use case?
     * 
     * @var bool
     */
    protected $displayDiagrammInDetailView = true;
    
    /**
     * How should the diagramm be displayed?
     * 
     * Possible values: image, text, both
     * 
     * @var string
     */
    protected $displayDiagrammAs = 'both';
    
    /**
     * Use case category entity class name
     *
     * @var string
     */
    protected $categoryEntityClass = 'DlcCategory\Entity\Category';

    /**
     * Use case dependency entity class name
     * 
     * @var string
     */
    protected $dependencyEntityClass = 'DlcUseCase\Entity\Dependency';
    
    /**
     * Use case entity class name
     * 
     * @var string
     */
    protected $useCaseEntityClass = 'DlcUseCase\Entity\UseCase';
    
    /**
     * Template file or string for generating doku wiki pages
     * 
     * If this option is false, no page will be generated.
     * 
     * @var string
     */
    protected $useCaseDokuWikiTemplate = 'data/templates/use_case_doku_wiki_template.txt';
    
    /**
     * Use case type entity class name
     *
     * @var string
     */
    protected $typeEntityClass = 'DlcUseCase\Entity\Type';
    
    /**
     * Use case priority entity class name
     *
     * @var string
     */
    protected $priorityEntityClass = 'DlcUseCase\Entity\Priority';
    
    /**
     * Default number of items per page
     * 
     * @var int
     */
    protected $defaultItemsPerPage = 15;
    
    /**
     * Getter for $rootCategoryId
     *
     * @return number $rootCategoryId
     */
    public function getRootCategoryId()
    {
        return $this->rootCategoryId;
    }

    /**
     * Setter for $rootCategoryId
     *
     * @param  number $rootCategoryId
     * @return ModuleOptions
     */
    public function setRootCategoryId($rootCategoryId)
    {
        $this->rootCategoryId = $rootCategoryId;
        return $this;
    }

    /**
     * Getter for $optionalFields
     *
     * @return multitype: $optionalFields
     */
    public function getOptionalFields()
    {
        return $this->optionalFields;
    }

    /**
     * Setter for $optionalFields
     *
     * @param  multitype: $optionalFields
     * @return ModuleOptions
     */
    public function setOptionalFields($optionalFields)
    {
        $this->optionalFields = $optionalFields;
        return $this;
    }

    /**
     * Getter for $displayDiagrammInDetailView
     *
     * @return boolean $displayDiagrammInDetailView
     */
    public function getDisplayDiagrammInDetailView()
    {
        return $this->displayDiagrammInDetailView;
    }

    /**
     * Setter for $displayDiagrammInDetailView
     *
     * @param  boolean $displayDiagrammInDetailView
     * @return ModuleOptions
     */
    public function setDisplayDiagrammInDetailView($displayDiagrammInDetailView)
    {
        $this->displayDiagrammInDetailView = $displayDiagrammInDetailView;
        return $this;
    }

    /**
     * Getter for $displayDiagrammAs
     *
     * @return string $displayDiagrammAs
     */
    public function getDisplayDiagrammAs()
    {
        return $this->displayDiagrammAs;
    }

    /**
     * Setter for $displayDiagrammAs
     *
     * @param  string $displayDiagrammAs
     * @return ModuleOptions
     */
    public function setDisplayDiagrammAs($displayDiagrammAs)
    {
        $this->displayDiagrammAs = $displayDiagrammAs;
        return $this;
    }

    /**
     * Getter for $categoryEntityClass
     *
     * @return string $categoryEntityClass
     */
    public function getCategoryEntityClass()
    {
        return $this->categoryEntityClass;
    }

    /**
     * Setter for $categoryEntityClass
     *
     * @param  string $categoryEntityClass
     * @return ModuleOptions
     */
    public function setCategoryEntityClass($categoryEntityClass)
    {
        $this->categoryEntityClass = $categoryEntityClass;
        return $this;
    }

    /**
     * Getter for $dependencyEntityClass
     *
     * @return string $dependencyEntityClass
     */
    public function getDependencyEntityClass()
    {
        return $this->dependencyEntityClass;
    }

    /**
     * Setter for $dependencyEntityClass
     *
     * @param  string $dependencyEntityClass
     * @return ModuleOptions
     */
    public function setDependencyEntityClass($dependencyEntityClass)
    {
        $this->dependencyEntityClass = $dependencyEntityClass;
        return $this;
    }

    /**
     * Getter for $useCaseEntityClass
     *
     * @return string $useCaseEntityClass
     */
    public function getUseCaseEntityClass()
    {
        return $this->useCaseEntityClass;
    }

    /**
     * Setter for $useCaseEntityClass
     *
     * @param  string $useCaseEntityClass
     * @return ModuleOptions
     */
    public function setUseCaseEntityClass($useCaseEntityClass)
    {
        $this->useCaseEntityClass = $useCaseEntityClass;
        return $this;
    }

    /**
     * Getter for $useCaseDokuWikiTemplate
     *
     * @return string $useCaseDokuWikiTemplate
     */
    public function getUseCaseDokuWikiTemplate ()
    {
        return $this->useCaseDokuWikiTemplate;
    }

    /**
     * Setter for $useCaseDokuWikiTemplate
     *
     * @param  string $useCaseDokuWikiTemplate
     * @return ModuleOptions
     */
    public function setUseCaseDokuWikiTemplate ($useCaseDokuWikiTemplate)
    {
        $this->useCaseDokuWikiTemplate = $useCaseDokuWikiTemplate;
        return $this;
    }

    /**
     * Getter for $typeEntityClass
     *
     * @return string $typeEntityClass
     */
    public function getTypeEntityClass()
    {
        return $this->typeEntityClass;
    }

    /**
     * Setter for $typeEntityClass
     *
     * @param  string $typeEntityClass
     * @return ModuleOptions
     */
    public function setTypeEntityClass($typeEntityClass)
    {
        $this->typeEntityClass = $typeEntityClass;
        return $this;
    }

    /**
     * Getter for $priorityEntityClass
     *
     * @return string $priorityEntityClass
     */
    public function getPriorityEntityClass()
    {
        return $this->priorityEntityClass;
    }

    /**
     * Setter for $priorityEntityClass
     *
     * @param  string $priorityEntityClass
     * @return ModuleOptions
     */
    public function setPriorityEntityClass($priorityEntityClass)
    {
        $this->priorityEntityClass = $priorityEntityClass;
        return $this;
    }
    /**
     * Getter for $defaultItemsPerPage
     *
     * @return number $defaultItemsPerPage
     */
    public function getDefaultItemsPerPage()
    {
        return $this->defaultItemsPerPage;
    }

    /**
     * Setter for $defaultItemsPerPage
     *
     * @param  number $defaultItemsPerPage
     * @return ModuleOptions
     */
    public function setDefaultItemsPerPage($defaultItemsPerPage)
    {
        $this->defaultItemsPerPage = $defaultItemsPerPage;
        return $this;
    }
}