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
}