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
            'diagramm'  => $diagramm,
        ));
        
        return $view;
    }
}