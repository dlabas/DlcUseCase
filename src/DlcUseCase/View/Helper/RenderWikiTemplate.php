<?php
namespace DlcUseCase\View\Helper;

use DlcBase\Code\Reflection\Closure as ReflectionClosure;
use DlcBase\Options\ModuleOptionsAwareInterface;
use DlcUseCase\Entity\UseCase;
use Zend\ServiceManager\ServiceLocatorAwareInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use Zend\View\Helper\AbstractHelper;

class RenderWikiTemplate extends AbstractHelper implements ModuleOptionsAwareInterface, ServiceLocatorAwareInterface
{
    /**
     * The entity for rendering the template
     *
     * @var \DlcUseCase\Entity\UseCase
     */
    protected $entity;

    /**
     * The module options
     *
     * @var \DlcUseCase\Options\ModuleOptions
     */
    protected $options;

    /**
     * Service locator
     *
     * @var ServiceLocatorInterface
     */
    protected $serviceLocator;

    /**
     * Getter for $entity
     *
     * @return \DlcUseCase\Entity\UseCase $entity
     */
    public function getEntity()
    {
        return $this->entity;
    }

    /**
     * Setter for $entity
     *
     * @param  \DlcUseCase\Entity\UseCase $entity
     * @return RenderWikiTemplate
     */
    public function setEntity(UseCase $entity)
    {
        $this->entity = $entity;
        return $this;
    }

    /**
     * Getter for $options
     *
     * @return \DlcUseCase\Options\ModuleOptions $options
     */
    public function getOptions()
    {
        if (null === $this->options) {
            $this->setOptions($this->getServiceLocator()->get('dlcusecase_module_options'));
        }
        return $this->options;
    }

    /**
     * Setter for $options
     *
     * @param  \DlcUseCase\Options\ModuleOptions $options
     * @return AbstractActionController
     */
    public function setOptions($options)
    {
        $this->options = $options;
        return $this;
    }

    /**
     * Getter for $serviceLocator
     *
     * @return \Zend\ServiceManager\ServiceLocatorInterface $serviceLocator
     */
    public function getServiceLocator()
    {
        return $this->serviceLocator;
    }

    /**
     * Setter for $serviceLocator
     *
     * @param  \Zend\ServiceManager\ServiceLocatorInterface $serviceLocator
     * @return RenderWikiTemplate
     */
    public function setServiceLocator(ServiceLocatorInterface $serviceLocator)
    {
        $this->serviceLocator = $serviceLocator;
        return $this;
    }

    public function getTemplate()
    {
        return file_get_contents(
            $this->getOptions()
                 ->getUseCaseDokuWikiTemplate()
        );
    }

    public function getPlaceholderToPropertyMap()
    {
        return $this->getOptions()
                    ->getUseCaseDokuWikiTemplatePlaceholders();
    }

    public function __toString()
    {
        return $this->render();
    }

    public function invoke($entity = null)
    {
        if (null !== $entity) {
            $this->setEntity($entity);
        }

        return $this;
    }

    public function render($entity = null)
    {
        if (null !== $entity) {
            $this->setEntity($entity);
        }

        $map      = $this->getPlaceholderToPropertyMap();
        $template = $this->getTemplate();
        $values   = array();
        $entity   = $this->getEntity();
        $view     = $this->getView();

        if ($entity === null) {
            return '';
        }

        foreach ($map as $placeholder => $property) {
            if (is_callable($property)) {
                $value = $property($entity, $view);
            } elseif (is_string($property)) {
                $getMethod = 'get' . ucfirst($property);
                if (method_exists($entity, $getMethod)) {
                    $value = $entity->$getMethod();
                } elseif (isset($entity->$property)) {
                    $value = $entity->$property;
                } else {
                    throw new \InvalidArgumentException('No getter or property found for "' . $property . '"');
                }
            } else {
                throw new \InvalidArgumentException('Unkown data type "' . gettype($property). '" for placeholder "' . $placeholder . '"');
            }
            $values[$placeholder] = $value;
        }

        $generatedPage = str_replace(array_keys($values), $values, $template);

        return $generatedPage;
    }

    public function renderMapAsArrayOfStrings()
    {
        $map = $this->getPlaceholderToPropertyMap();

        foreach ($map as $placeholder => $property) {
            if (is_callable($property)) {
                $reflection        = new ReflectionClosure($property);
                $map[$placeholder] = $reflection->getSourceCode();
            }
        }

        return $map;
    }
}