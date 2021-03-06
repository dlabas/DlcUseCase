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
     * Should the diagramm image be renderd (generated) in PHP or in JavaScript? (At the moment only for use case detail view)
     *
     * Possible values: php, javascript
     *
     * @var string
     */
    protected $renderDiagrammImageStrategy = 'javascript';

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
     * Placeholder to property map for doku wiki template
     *
     * @var array
     */
    protected $useCaseDokuWikiTemplatePlaceholders;

    /**
     * Template file or string for generating doku wiki pages
     *
     * If this option is false, no page will be generated.
     *
     * @var string
     */
    protected $useCaseDokuWikiTemplate = 'data/templates/use_case_doku_wiki_template.txt';

    /**
     * Directory of txt files from doku wiki for auto import
     *
     * @var string
     */
    protected $useCaseDokuWikiTxtFilesDir = 'data/usecases';

    /**
     *
     * @var string
     */
    protected $dokuWikiUrl = 'https://intern.cuculus.net/wiki/doku.php';

    /**
     *
     * @var string
     */
    protected $dokuWikiIdPrefix = 'team_core:zonos-core-mvc-concept:usecases';

    /**
     *
     * @var bool
     */
    protected $dropUseCasesBeforeImport = true;

    /**
     *
     * @var array
     */
    protected $excludeFilenamesFromImport = array('start.txt', 'template.txt', 'usecases.txt');

    /**
     *
     * @var array
     */
    protected $txtImportPositions = array(
        'name' => array(
            'start' => '====== ',
            'end'   => ' ======',
            'trim'  => true,
        ),
        'type' => array(
            'start'   => '===== Typ =====',
            'end'     => '===== Kategorie =====',
            'replace' => array(
                'search'  => array(
                    '*',
                    '[[team_core:zonos-core-mvc-concept:usecases:business:start]]',
                    '[[team_core:zonos-core-mvc-concept:usecases:system:start]]',
                    '[[team_core:zonos-core-mvc-concept:usecases:business:portal-api:start]]',
                    '[[team_core:zonos-core-mvc-concept:usecases:business:zcp-api:start]]',
                    '[[team_core:zonos-core-mvc-concept:usecases:business:sap-api:start]]',
                    '[[team_core:zonos-core-mvc-concept:usecases:business:file-based-imports:start]]',
                    '[[team_core:zonos-core-mvc-concept:usecases:business:misc:start]]'
                ),
                'replace' => array(
                    '',
                    'Business Use Case',
                    'System Use Case',
                    'Business Use Case - Portal-API',
                    'Business Use Case - ZCP API',
                    'Business Use Case - SAP API',
                    'Business Use Case - Dateibasierter Import',
                    'Business Use Case - Verschiedenes'
                ),
            ),
            'trim'    => true,
        ),
        'category'     => array(
            'start'   => '===== Kategorie =====',
            'end'     => '===== Beschreibung =====',
            'replace' => array(
                'search'  => array('*'),
                'replace' => array(''),
            ),
            'trim'    => true,
        ),
        'description'  => array(
            'start' => '===== Beschreibung =====',
            'end'   => '===== Priorität =====',
            'trim'  => false,
        ),
        'priority'     => array(
            'start'   => '===== Priorität =====',
            'end'     => '===== Details =====',
            'replace' => array(
                'search'  => array('*'),
                'replace' => array(''),
            ),
            'trim'    => true,
        ),
        'details'      => array(
            'start' => '===== Details =====',
            'end'   => '===== Bemerkungen  ====='
        ),
        'comment'     => array(
            'start' => '===== Bemerkungen  =====',
            'end'   => '===== Eingehende Daten ====='
        ),
        'inputData'    => array(
            'start' => '===== Eingehende Daten =====',
            'end'   => '===== Ausgehende Daten ====='
        ),
        'outputData'   => array(
            'start' => '===== Ausgehende Daten =====',
            'end'   => '===== Abhängigkeiten zu anderen Use Cases ====='
        ),
        'dependencies' => array(
            'start'   => '===== Abhängigkeiten zu anderen Use Cases =====',
            'end'     => null,
            'replace' => array(
                'search'  => array('*'),
                'replace' => array(''),
            ),
            'trim'    => true,
        ),
    );

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
    protected $defaultItemsPerPage = 25;

    /**
     * Filter modal partial view script
     *
     * @var string
     */
    protected $filterModalViewScript = 'dlc-use-case/partials/filterModal.phtml';

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
     * Getter for $renderDiagrammImageStrategy
     *
     * @return string $renderDiagrammImageStrategy
     */
    public function getRenderDiagrammImageStrategy()
    {
        return $this->renderDiagrammImageStrategy;
    }

    /**
     * Setter for $renderDiagrammImageStrategy
     *
     * @param  string $renderDiagrammImageStrategy
     * @return ModuleOptions
     */
    public function setRenderDiagrammImageStrategy($renderDiagrammImageStrategy)
    {
        $this->renderDiagrammImageStrategy = $renderDiagrammImageStrategy;
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
     * Getter for $useCaseDokuWikiTemplatePlaceholders
     *
     * @return multitype: $useCaseDokuWikiTemplatePlaceholders
     */
    public function getUseCaseDokuWikiTemplatePlaceholders()
    {
        if (null === $this->useCaseDokuWikiTemplatePlaceholders) {
            $this->useCaseDokuWikiTemplatePlaceholders = array(
                '#NAME#'         => 'name',
                '#TYPE#'         => function ($entity, $view) {
                    if ($entity->getType()) {
                        return $entity->getType()->getName();
                    } else {
                        return '';
                    }
                },
                '#CATEGORY#'     => 'categoryTitle',
                '#DESCRIPTION#'  => 'description',
                '#PRIORITY#'     => 'priorityName',
                '#DETAILS#'      => 'details',
                '#COMMENT#'      => 'comment',
                '#INPUT_DATA#'   => 'inputData',
                '#OUTPUT_DATA#'  => 'outputData',
                '#DEPENDENCIES#' => function ($entity, $view) {
                    $dependencies =  $entity->getDependencies();
                    $depString    = '';
                    foreach ($dependencies as $dependency) {
                        $depString .= '  * (' . $dependency->getType() . ') ' . $dependency->getToNode()->getName() . PHP_EOL;
                    }
                    return $depString;
                },
                '#LINK_TO_USE_CASES_APP#' => function ($entity, $view) {
                    $link = isset($_SERVER['HTTPS']) ? 'https://' : 'http://'
                          . $_SERVER['HTTP_HOST']
                          . $view->url('dlcusecase/show', array('id' => $entity->getId()));

                    return $link;
                },
            );
        }
        return $this->useCaseDokuWikiTemplatePlaceholders;
    }

    /**
     * Setter for $useCaseDokuWikiTemplatePlaceholders
     *
     * @param  multitype: $useCaseDokuWikiTemplatePlaceholders
     * @return ModuleOptions
     */
    public function setUseCaseDokuWikiTemplatePlaceholders(
            $useCaseDokuWikiTemplatePlaceholders)
    {
        $this->useCaseDokuWikiTemplatePlaceholders = $useCaseDokuWikiTemplatePlaceholders;
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
     * Getter for $useCaseDokuWikiTxtFilesDir
     *
     * @return string $useCaseDokuWikiTxtFilesDir
     */
    public function getUseCaseDokuWikiTxtFilesDir()
    {
        return $this->useCaseDokuWikiTxtFilesDir;
    }

    /**
     * Setter for $useCaseDokuWikiTxtFilesDir
     *
     * @param  string $useCaseDokuWikiTxtFilesDir
     * @return ModuleOptions
     */
    public function setUseCaseDokuWikiTxtFilesDir($useCaseDokuWikiTxtFilesDir)
    {
        $this->useCaseDokuWikiTxtFilesDir = $useCaseDokuWikiTxtFilesDir;
        return $this;
    }

    /**
     * Getter for $dokuWikiUrl
     *
     * @return string $dokuWikiUrl
     */
    public function getDokuWikiUrl()
    {
        return $this->dokuWikiUrl;
    }

    /**
     * Getter for $dokuWikiIdPrefix
     *
     * @return string $dokuWikiIdPrefix
     */
    public function getDokuWikiIdPrefix()
    {
        return $this->dokuWikiIdPrefix;
    }

    /**
     * Setter for $dokuWikiUrl
     *
     * @param  string $dokuWikiUrl
     * @return ModuleOptions
     */
    public function setDokuWikiUrl($dokuWikiUrl)
    {
        $this->dokuWikiUrl = $dokuWikiUrl;
        return $this;
    }

    /**
     * Setter for $dokuWikiIdPrefix
     *
     * @param  string $dokuWikiIdPrefix
     * @return ModuleOptions
     */
    public function setDokuWikiIdPrefix($dokuWikiIdPrefix)
    {
        $this->dokuWikiIdPrefix = $dokuWikiIdPrefix;
        return $this;
    }

    /**
     * Getter for $dropUseCasesBeforeImport
     *
     * @return boolean $dropUseCasesBeforeImport
     */
    public function getDropUseCasesBeforeImport()
    {
        return $this->dropUseCasesBeforeImport;
    }

    /**
     * Getter for $excludeFilenamesFromImport
     *
     * @return multitype: $excludeFilenamesFromImport
     */
    public function getExcludeFilenamesFromImport()
    {
        return $this->excludeFilenamesFromImport;
    }

    /**
     * Setter for $dropUseCasesBeforeImport
     *
     * @param  boolean $dropUseCasesBeforeImport
     * @return ModuleOptions
     */
    public function setDropUseCasesBeforeImport($dropUseCasesBeforeImport)
    {
        $this->dropUseCasesBeforeImport = $dropUseCasesBeforeImport;
        return $this;
    }

    /**
     * Setter for $excludeFilenamesFromImport
     *
     * @param  multitype: $excludeFilenamesFromImport
     * @return ModuleOptions
     */
    public function setExcludeFilenamesFromImport($excludeFilenamesFromImport)
    {
        $this->excludeFilenamesFromImport = $excludeFilenamesFromImport;
        return $this;
    }

    /**
     * Getter for $txtImportPositions
     *
     * @return multitype: $txtImportPositions
     */
    public function getTxtImportPositions()
    {
        return $this->txtImportPositions;
    }

    /**
     * Setter for $txtImportPositions
     *
     * @param  multitype: $txtImportPositions
     * @return ModuleOptions
     */
    public function setTxtImportPositions($txtImportPositions)
    {
        $this->txtImportPositions = $txtImportPositions;
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

    /**
     * Getter for $filterModalViewScript
     *
     * @return string $filterModalViewScript
     */
    public function getFilterModalViewScript()
    {
        return $this->filterModalViewScript;
    }


    /**
     * Setter for $filterModalViewScript
     *
     * @param  string $filterModalViewScript
     * @return ModuleOptions
     */
    public function setFilterModalViewScript($filterModalViewScript)
    {
        $this->filterModalViewScript = $filterModalViewScript;
        return $this;
    }

}