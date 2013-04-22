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