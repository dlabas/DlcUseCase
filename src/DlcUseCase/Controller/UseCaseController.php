<?php
namespace DlcUseCase\Controller;

use DlcBase\Controller\AbstractEntityActionController;
use Zend\Session\Container;
use Zend\Stdlib\ResponseInterface as Response;
use Zend\View\Model\ViewModel;

class UseCaseController extends AbstractEntityActionController
{
    /**
     * Returns the prefix for the route identifier
     */
    public function getRouteIdentifierPrefix()
    {
        if ($this->routeIdentifierPrefix === null) {
            $this->routeIdentifierPrefix = strtolower($this->getModuleNamespace());
        }
        return $this->routeIdentifierPrefix;
    }

    public function indexAction()
    {
        $filterForm = $this->getServiceLocator()->get('dlcusecase_usecasefilter_form');
        //Get post data
        $post = $this->params()->fromPost();
        //Session stuff
        $sessionManager      = Container::getDefaultManager();
        $sessionStorage      = $sessionManager->getStorage();
        $sessionStorageArray = $sessionStorage->toArray();

        if (isset($post['filter'])) {
            $filter = $post['filter'];
        } else {
            if (isset($sessionStorageArray['dlcusecase_filter'])) {
                $filter = $sessionStorageArray['dlcusecase_filter'];
            } else {
                $filter = array();
            }
        }

        //Set filter form data
        $formData = array();
        foreach ($filter as $key => $value) {
            $formData['filter[' . $key . ']'] = $value;
        }
        $filterForm->setData($formData);

        $query = (string) $this->params()->fromQuery('query', null);
        $query = strlen($query) > 0 ? $query : null;

        $orderBy = (string) $this->params()->fromQuery('orderBy', null);
        $orderBy = strlen($orderBy) > 0 ? $orderBy : null;

        $sort = (string) $this->params()->fromQuery('sort', null);
        $sort = strlen($sort) > 0 ? $sort : null;

        $page  = (int) $this->params()->fromRoute('page', 1);

        $limit = $this->params()->fromQuery('itemsPerPage', null);
        if ($limit === null && !isset($sessionStorageArray['dlcusecase_limit'])) {
            $limit = $this->getOptions()->getDefaultItemsPerPage();
        } elseif ($limit === null && isset($sessionStorageArray['dlcusecase_limit'])) {
            $limit = $sessionStorageArray['dlcusecase_limit'];
        }

        $sessionStorageArray['dlcusecase_filter'] = $filter;
        $sessionStorageArray['dlcusecase_limit']  = $limit;
        $sessionStorage->fromArray($sessionStorageArray);

        $entities = $this->getService()->pagination($page, $limit, $query, $orderBy, $sort, $filter);

        $view = new ViewModel(array(
            'options'    => $this->getOptions(),
            'entities'   => $entities,
            'query'      => $query,
            'orderBy'    => $orderBy,
            'sort'       => $sort,
            'filterForm' => $filterForm,
        ));

        return $view;
    }

    public function diagrammAction()
    {
        $diagramm = $this->getService()->createUseCaseDiagramm();

        $view = new ViewModel(array(
            'diagramm' => $diagramm,
            'options'  => $this->getOptions(),
        ));

        return $view;
    }

    /**
     * Show action for viewing a single entity
     *
     * @return \Zend\View\Model\ViewModel
     */
    public function showAction()
    {
        $id = (int) $this->params()->fromRoute('id', null);

        $service = $this->getService();
        $entity  = $service->getById($id);

        $view = new ViewModel(array(
            'entity'  => $entity,
            'options' => $this->getOptions(),
        ));

        if ($this->getOptions()->getDisplayDiagrammInDetailView()) {
            $diagramm = $this->getService()->createUseCaseDiagrammFor($entity);
            $view->setVariable('diagramm', $diagramm);
        }

        return $view;
    }

    /**
     * Show wiki template action
     *
     * @return \Zend\View\Model\ViewModel
     */
    public function showWikiTemplateAction()
    {
        $view = new ViewModel(array(
            'template' => file_get_contents($this->getOptions()->getUseCaseDokuWikiTemplate()),
            'options'  => $this->getOptions(),
        ));

        return $view;
    }

    /**
     * Edit wiki template action
     *
     * @return \Zend\View\Model\ViewModel
     */
    public function editWikiTemplateAction()
    {
        $templateFile = $this->getOptions()->getUseCaseDokuWikiTemplate();

        if (!is_writeable($templateFile)) {
            throw new \RuntimeException(sprintf(
                    'Template file "%s" is not writeable. Please fix the file priviliges first!',
                    $templateFile
            ));
        }

        $request = $this->getRequest();
        $form    = $this->getServiceLocator()->get('dlcusecase_editwikitemplate_form');

        if ($request->getQuery()->get('redirect')) {
            $redirect = $request->getQuery()->get('redirect');
        } else {
            $redirect = false;
        }

        $redirectUrl = $this->url()->fromRoute($this->getRouteIdentifierPrefix() . '/edit-wiki-template')
                     . ($redirect ? '?redirect=' . $redirect : '');

        $prg = $this->prg($redirectUrl, true);

        if ($prg instanceof Response) {
            return $prg;
        } elseif ($prg === false) {
            return array(
                'form' => $form,
                'options'  => $this->getOptions(),
            );
        }

        $post     = $prg;
        $redirect = isset($prg['redirect']) ? $prg['redirect'] : null;

        $form->setData($post);

        if (!$form->isValid()) {
            return array(
                'options'  => $this->getOptions(),
                'form'     => $form,
                'redirect' => $redirect,
            );
        }

        $formData = $form->getData();

        file_put_contents($this->getOptions()->getUseCaseDokuWikiTemplate(), $formData['wiki-template']);

        // TODO: Add the redirect parameter here...
        return $this->redirect()->toUrl($this->url()->fromRoute($this->getRouteIdentifierPrefix() . '/show-wiki-template') . ($redirect ? '?redirect='.$redirect : ''));
    }
}