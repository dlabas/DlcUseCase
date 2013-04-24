<?php
namespace DlcUseCase\Controller;

use DlcBase\Controller\AbstractEntityActionController;
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