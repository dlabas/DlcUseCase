<?php
namespace DlcUseCase;

use DlcBase\Module\AbstractModule;
use Zend\Mvc\ModuleRouteListener;
use Zend\Session\Config\SessionConfig;
use Zend\Session\SessionManager;
use Zend\Session\Container;

class Module extends AbstractModule
{
    public function onBootstrap(\Zend\EventManager\EventInterface $e)
    {
        $sm = $e->getApplication()->getServiceManager();

        $config = $sm->get('session_config');

        $storage = null;
        if ($sm->canCreate('session_storage', false)) {
            $storage = $sm->get('session_storage');
        }

        $saveHandler = null;
        if ($sm->canCreate('session_save_handler', false)) {
            $saveHandler = $sm->get('session_save_handler');
        }

        $sessionManager = new SessionManager($config, $storage, $saveHandler);
        Container::setDefaultManager($sessionManager);

        $sessionManager->start();
    }

    public function getViewHelperConfig()
    {
        return array(
            'factories' => array(
                'dlcRenderWikiTemplate' => function($sm) {
                    $sm = $sm->getServiceLocator(); // $sm was the view helper's locator
                    $options = $sm->get('dlcusecase_module_options');

                    $helper = new \DlcUseCase\View\Helper\RenderWikiTemplate();
                    $helper->setOptions($options);
                    return $helper;
                }
            )
        );
    }

    public function getServiceConfig()
    {
        return array(
            'aliases' => array(
                'dlcusecase_doctrine_em' => 'doctrine.entitymanager.orm_default',
            ),

            'invokables' => array(
                'dlcusecase_addpriority_form'      => 'DlcUseCase\Form\AddPriority',
                'dlcusecase_addtype_form'          => 'DlcUseCase\Form\AddType',
                'dlcusecase_addusecase_form'       => 'DlcUseCase\Form\AddUseCase',
                'dlcusecase_dependency_fieldset'   => 'DlcUseCase\Form\DependencyFieldset',
                'dlcusecase_editpriority_form'     => 'DlcUseCase\Form\EditPriority',
                'dlcusecase_edittype_form'         => 'DlcUseCase\Form\EditType',
                'dlcusecase_editusecase_form'      => 'DlcUseCase\Form\EditUseCase',
                'dlcusecase_editwikitemplate_form' => 'DlcUseCase\Form\EditWikiTemplate',
                'dlcusecase_priority_mapper'       => 'DlcUseCase\Mapper\Priority',
                'dlcusecase_priority_service'      => 'DlcUseCase\Service\Priority',
                'dlcusecase_type_mapper'           => 'DlcUseCase\Mapper\Type',
                'dlcusecase_type_service'          => 'DlcUseCase\Service\Type',
                'dlcusecase_usecasefilter_form'    => 'DlcUseCase\Form\UseCaseFilter',
                'dlcusecase_usecase_mapper'        => 'DlcUseCase\Mapper\UseCase',
                'dlcusecase_usecase_service'       => 'DlcUseCase\Service\UseCase',
                'dlcusecase_setup_service'         => 'DlcUseCase\Service\Setup',
            ),

            'factories' => array(
                'dlcusecase_module_options' => function ($sm) {
                    $config = $sm->get('Config');
                    return new Options\ModuleOptions(isset($config['dlcusecase']) ? $config['dlcusecase'] : array());
                },
                'dlcusecase_dependency_hydrator' => function ($sm) {
                    $objectManager = $sm->get('dlcusecase_doctrine_em');
                    $options       = $sm->get('dlcusecase_module_options');
                    $hydrator      = new \DoctrineModule\Stdlib\Hydrator\DoctrineObject(
                            $objectManager,
                            $options->getDependencyEntityClass()
                    );
                    return $hydrator;
                },
                'dlcusecase_priority_hydrator' => function ($sm) {
                    $objectManager = $sm->get('dlcusecase_doctrine_em');
                    $options       = $sm->get('dlcusecase_module_options');
                    $hydrator      = new \DoctrineModule\Stdlib\Hydrator\DoctrineObject(
                            $objectManager,
                            $options->getPriorityEntityClass()
                    );
                    return $hydrator;
                },
                'dlcusecase_type_hydrator' => function ($sm) {
                    $objectManager = $sm->get('dlcusecase_doctrine_em');
                    $options       = $sm->get('dlcusecase_module_options');
                    $hydrator      = new \DoctrineModule\Stdlib\Hydrator\DoctrineObject(
                        $objectManager,
                        $options->getTypeEntityClass()
                    );
                    return $hydrator;
                },
                'dlcusecase_usecase_hydrator' => function ($sm) {
                    $objectManager = $sm->get('dlcusecase_doctrine_em');
                    $options       = $sm->get('dlcusecase_module_options');
                    $hydrator      = new \DoctrineModule\Stdlib\Hydrator\DoctrineObject(
                            $objectManager,
                            $options->getUseCaseEntityClass()
                    );
                    return $hydrator;
                },
                'sessionconfig' => function ($sm) {
                    $config = $sm->get('Config');

                    $sessionConfig = new SessionConfig();
                    if (isset($config['session'])) {
                        $sessionConfig->setOptions($config['session']);
                    }

                    return $sessionConfig;
                },
            ),
        );
    }
}