<?php
namespace DlcUseCase;

return array(
    'controllers' => array(
        'invokables' => array(
            'dlcusecase'          => 'DlcUseCase\Controller\UseCaseController',
            'dlcusecase_priority' => 'DlcUseCase\Controller\PriorityController',
            'dlcusecase_type'     => 'DlcUseCase\Controller\TypeController',
        ),
    ),

    'dlcdoctrine' => array(
        'resolveTargetEntities' => array(
            //$originalEntity => array($newEntity, $mapping) //Params of ResolveTargetEntityListener::addResolveTargetEntity
            'DlcCategory\Entity\CategoryInterface' => array(
                'newEntity' => 'DlcCategory\Entity\Category',
                'mapping'   => array(),
            ),
        ),
    ),

    'DlcFile\Entity\FileInterface' => array(
        'newEntity' => 'DlcFile\Entity\File',
        'mapping'   => array(),
    ),

    // Doctrine config
    'doctrine' => array(
        'driver' => array(
            __NAMESPACE__ . '_driver' => array(
                'class' => 'Doctrine\ORM\Mapping\Driver\AnnotationDriver',
                'cache' => 'array',
                'paths' => array(__DIR__ . '/../src/' . __NAMESPACE__ . '/Entity')
            ),
            'orm_default' => array(
                'drivers' => array(
                    __NAMESPACE__ . '\Entity' => __NAMESPACE__ . '_driver'
                )
            )
        )
    ),

    'router' => array(
        'routes' => array(
            'dlcusecase' => array(
                'type' => 'Literal',
                'priority' => 1000,
                'options' => array(
                    'route' => '/usecase',
                    'defaults' => array(
                        'controller' => 'dlcusecase',
                        'action'     => 'index',
                    ),
                ),
                'may_terminate' => true,
                'child_routes' => array(
                    'index' => array(
                        'type' => 'Segment',
                        'options' => array(
                            'route'    => '[/page/:page]',
                            'constraints' => array(
                                'page'     => '[0-9]+',
                            ),
                            'defaults' => array(
                                'controller' => 'dlcusecase',
                                'action'     => 'index',
                                'page'       => 1,
                            ),
                        ),
                        'may_terminate' => true,
                    ),
                    'diagramm' => array(
                        'type' => 'Literal',
                        'options' => array(
                            'route'    => '/diagramm',
                            'defaults' => array(
                                'controller' => 'dlcusecase',
                                'action'     => 'diagramm',
                            ),
                        ),
                        'may_terminate' => true,
                    ),
                    'list' => array(
                        'type' => 'Segment',
                        'options' => array(
                            'route'    => '/list[/page/:page]',
                            'constraints' => array(
                                'page'     => '[0-9]+',
                            ),
                            'defaults' => array(
                                'controller' => 'dlcusecase',
                                'action'     => 'list',
                                'page'       => 1,
                            ),
                        ),
                        'may_terminate' => true,
                    ),
                    'show' => array(
                        'type' => 'Segment',
                        'options' => array(
                            'route'    => '/show/:id',
                            'constraints' => array(
                                'id'     => '[0-9]+',
                            ),
                            'defaults' => array(
                                'controller' => 'dlcusecase',
                                'action'     => 'show',
                                'id'         => null,
                            ),
                        ),
                        'may_terminate' => true,
                    ),
                    'add' => array(
                        'type' => 'Literal',
                        'options' => array(
                            'route'    => '/add',
                            'defaults' => array(
                                'controller' => 'dlcusecase',
                                'action'     => 'add',
                            ),
                        ),
                        'may_terminate' => true,
                    ),
                    'edit' => array(
                        'type' => 'Segment',
                        'options' => array(
                            'route'    => '/edit/:id',
                            'constraints' => array(
                                'id'     => '[0-9]+',
                            ),
                            'defaults' => array(
                                'controller' => 'dlcusecase',
                                'action'     => 'edit',
                                'id'         => null,
                            ),
                        ),
                        'may_terminate' => true,
                    ),
                    'delete' => array(
                        'type' => 'Segment',
                        'options' => array(
                            'route'    => '/delete/:id',
                            'constraints' => array(
                                'id'     => '[0-9]+',
                            ),
                            'defaults' => array(
                                'controller' => 'dlcusecase',
                                'action'     => 'delete',
                                'id'         => null,
                            ),
                        ),
                        'may_terminate' => true,
                    ),
                    'show-wiki-template' => array(
                        'type' => 'Literal',
                        'options' => array(
                            'route'    => '/show-wiki-template',
                            'defaults' => array(
                                'controller' => 'dlcusecase',
                                'action'     => 'showWikiTemplate',
                            ),
                        ),
                        'may_terminate' => true,
                    ),
                    'edit-wiki-template' => array(
                        'type' => 'Literal',
                        'options' => array(
                            'route'    => '/edit-wiki-template',
                            'defaults' => array(
                                'controller' => 'dlcusecase',
                                'action'     => 'editWikiTemplate',
                            ),
                        ),
                        'may_terminate' => true,
                    ),
                    /**
                     * PRIORITY ROUTES
                     */
                    'priority' => array(
                        'type' => 'Literal',
                        'priority' => 1000,
                        'options' => array(
                            'route' => '/priority',
                            'defaults' => array(
                                'controller' => 'dlcusecase_priority',
                                'action'     => 'index',
                            ),
                        ),
                        'may_terminate' => true,
                        'child_routes' => array(
                            'index' => array(
                                'type' => 'Segment',
                                'options' => array(
                                    'route'    => '[/page/:page]',
                                    'constraints' => array(
                                        'page'     => '[0-9]+',
                                    ),
                                    'defaults' => array(
                                        'controller' => 'dlcusecase_priority',
                                        'action'     => 'index',
                                        'page'       => 1,
                                    ),
                                ),
                                'may_terminate' => true,
                            ),
                            'list' => array(
                                'type' => 'Segment',
                                'options' => array(
                                    'route'    => '/list[/page/:page]',
                                    'constraints' => array(
                                        'page'     => '[0-9]+',
                                    ),
                                    'defaults' => array(
                                        'controller' => 'dlcusecase_priority',
                                        'action'     => 'index',
                                        'page'       => 1,
                                    ),
                                ),
                                'may_terminate' => true,
                            ),
                            'show' => array(
                                'type' => 'Segment',
                                'options' => array(
                                    'route'    => '/show/:id',
                                    'constraints' => array(
                                        'id'     => '[0-9]+',
                                    ),
                                    'defaults' => array(
                                        'controller' => 'dlcusecase_priority',
                                        'action'     => 'show',
                                        'id'         => null,
                                    ),
                                ),
                                'may_terminate' => true,
                            ),
                            'add' => array(
                                'type' => 'Literal',
                                'options' => array(
                                    'route'    => '/add',
                                    'defaults' => array(
                                        'controller' => 'dlcusecase_priority',
                                        'action'     => 'add',
                                    ),
                                ),
                                'may_terminate' => true,
                            ),
                            'edit' => array(
                                'type' => 'Segment',
                                'options' => array(
                                    'route'    => '/edit/:id',
                                    'constraints' => array(
                                        'id'     => '[0-9]+',
                                    ),
                                    'defaults' => array(
                                        'controller' => 'dlcusecase_priority',
                                        'action'     => 'edit',
                                        'id'         => null,
                                    ),
                                ),
                                'may_terminate' => true,
                            ),
                            'delete' => array(
                                'type' => 'Segment',
                                'options' => array(
                                    'route'    => '/delete/:id',
                                    'constraints' => array(
                                        'id'     => '[0-9]+',
                                    ),
                                    'defaults' => array(
                                        'controller' => 'dlcusecase_priority',
                                        'action'     => 'delete',
                                        'id'         => null,
                                    ),
                                ),
                                'may_terminate' => true,
                            ),
                        ),
                    ),
                    /**
                     * TYPE ROUTES
                     */
                    'type' => array(
                        'type' => 'Literal',
                        'priority' => 1000,
                        'options' => array(
                            'route' => '/type',
                            'defaults' => array(
                                'controller' => 'dlcusecase_type',
                                'action'     => 'index',
                            ),
                        ),
                        'may_terminate' => true,
                        'child_routes' => array(
                            'index' => array(
                                'type' => 'Segment',
                                'options' => array(
                                    'route'    => '[/page/:page]',
                                    'constraints' => array(
                                        'page'     => '[0-9]+',
                                    ),
                                    'defaults' => array(
                                        'controller' => 'dlcusecase_type',
                                        'action'     => 'index',
                                        'page'       => 1,
                                    ),
                                ),
                                'may_terminate' => true,
                            ),
                            'list' => array(
                                'type' => 'Segment',
                                'options' => array(
                                    'route'    => '/list[/page/:page]',
                                    'constraints' => array(
                                        'page'     => '[0-9]+',
                                    ),
                                    'defaults' => array(
                                        'controller' => 'dlcusecase_type',
                                        'action'     => 'list',
                                        'page'       => 1,
                                    ),
                                ),
                                'may_terminate' => true,
                            ),
                            'show' => array(
                                'type' => 'Segment',
                                'options' => array(
                                    'route'    => '/show/:id',
                                    'constraints' => array(
                                        'id'     => '[0-9]+',
                                    ),
                                    'defaults' => array(
                                        'controller' => 'dlcusecase_type',
                                        'action'     => 'show',
                                        'id'         => null,
                                    ),
                                ),
                                'may_terminate' => true,
                            ),
                            'add' => array(
                                'type' => 'Literal',
                                'options' => array(
                                    'route'    => '/add',
                                    'defaults' => array(
                                        'controller' => 'dlcusecase_type',
                                        'action'     => 'add',
                                    ),
                                ),
                                'may_terminate' => true,
                            ),
                            'edit' => array(
                                'type' => 'Segment',
                                'options' => array(
                                    'route'    => '/edit/:id',
                                    'constraints' => array(
                                        'id'     => '[0-9]+',
                                    ),
                                    'defaults' => array(
                                        'controller' => 'dlcusecase_type',
                                        'action'     => 'edit',
                                        'id'         => null,
                                    ),
                                ),
                                'may_terminate' => true,
                            ),
                            'delete' => array(
                                'type' => 'Segment',
                                'options' => array(
                                    'route'    => '/delete/:id',
                                    'constraints' => array(
                                        'id'     => '[0-9]+',
                                    ),
                                    'defaults' => array(
                                        'controller' => 'dlcusecase_type',
                                        'action'     => 'delete',
                                        'id'         => null,
                                    ),
                                ),
                                'may_terminate' => true,
                            ),
                        ),
                    ),
                ),
            ),
        ),
    ),

    'session' => array(
        'use_cookies'      => true,
        'use_only_cookies' => true,
        'cookie_httponly'  => true,
        'name'             => 'DLCUSECASE',
    ),

    'view_helpers' => array(
        'invokables' => array(
        ),
    ),

    'view_manager' => array(
        'template_path_stack' => array(
            'dlcusecase' => __DIR__ . '/../view',
        ),
    ),
);