<?php
namespace DlcUseCase\Entity;

use DlcDiagramm\Diagramm\Dependency\DependencyInterface;
use DlcDiagramm\Diagramm\Node as DiagrammNode;
use DlcDiagramm\Diagramm\Node\NodeInterface as DiagrammNodeInterface;
use DlcDoctrine\Entity\AbstractProvidesHistoryEntity;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Zend\Stdlib\ArrayObject;

/**
 * The use case entity
 *
 * @ORM\Entity
 * @ORM\HasLifecycleCallbacks
 * @ORM\Table(name="use_cases")
 */
class UseCase extends AbstractProvidesHistoryEntity implements DiagrammNodeInterface
{
    /**
     * @ORM\Id @ORM\Column(type="integer")
     * @ORM\GeneratedValue
     * @var int
     */
    protected $id;
    
    /**
     * @ORM\Column(type="string",length=100,unique=false)
     * @var string
     */
    protected $name;
    
    /**
     * @ORM\ManyToOne(targetEntity="Type")
     * @ORM\JoinColumn(name="type_id", referencedColumnName="id")
     * @var Type
     */
    protected $type;
    
    /**
     * @ORM\ManyToOne(targetEntity="DlcCategory\Entity\CategoryInterface")
     * @ORM\JoinColumn(name="category_id", referencedColumnName="id")
     * @var \DlcCategory\Entity\Category
     */
    protected $category;
    
    /**
     * @ORM\ManyToOne(targetEntity="Priority")
     * @ORM\JoinColumn(name="priority_id", referencedColumnName="id")
     * @var Priority
     */
    protected $priority;
    
    /**
     * @ORM\Column(type="string")
     * @var string
     */
    protected $link;
    
    /**
     * @ORM\Column(type="string",nullable=true)
     * @var string
     */
    protected $note;
    
    /**
     * Dependencies of this node
     * 
     * @ORM\OneToMany(targetEntity="Dependency", mappedBy="fromNode",cascade={"persist", "remove"})
     * @var ArrayObject
     */
    protected $dependencies;
    
    /**
     * Dependencies of this node
     *
     * @ORM\OneToMany(targetEntity="Dependency", mappedBy="toNode")
     * @var ArrayObject
     */
    protected $usedByDependencies;
    
    /**
     * The constructor
     */
    public function __construct()
    {
        $this->dependencies       = new ArrayCollection();
        $this->usedByDependencies = new ArrayCollection();
    }

    /**
     * Getter for $id
     *
     * @return number $id
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Setter for $id
     *
     * @param  number $id
     * @return UseCase
     */
    public function setId($id)
    {
        $this->id = $id;
        return $this;
    }

    /**
     * Getter for $name
     *
     * @return string $name
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Setter for $name
     *
     * @param  string $name
     * @return UseCase
     */
    public function setName($name)
    {
        $this->name = $name;
        return $this;
    }
    
    /**
     * Returns the extended name
     * 
     * @return string
     */
    public function getExtendedName()
    {
        $extendedName = $this->getType()->getName() 
                      . ' - ' . $this->getCategory()->getTitle() 
                      . ' - ' . $this->getName();
        return $extendedName;
    }

    /**
     * Getter for $type
     *
     * @return \DlcUseCase\Entity\Type $type
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Setter for $type
     *
     * @param  \DlcUseCase\Entity\Type $type
     * @return UseCase
     */
    public function setType($type)
    {
        $this->type = $type;
        return $this;
    }

    /**
     * Getter for $category
     *
     * @return \DlcCategory\Entity\Category $category
     */
    public function getCategory()
    {
        return $this->category;
    }

    /**
     * Setter for $category
     *
     * @param  \DlcCategory\Entity\Category $category
     * @return UseCase
     */
    public function setCategory($category)
    {
        $this->category = $category;
        return $this;
    }

    /**
     * Getter for $priority
     *
     * @return \DlcUseCase\Entity\Priority $priority
     */
    public function getPriority()
    {
        return $this->priority;
    }

    /**
     * Setter for $priority
     *
     * @param  \DlcUseCase\Entity\Priority $priority
     * @return UseCase
     */
    public function setPriority($priority)
    {
        $this->priority = $priority;
        return $this;
    }
    
    /**
     * Getter for $link
     *
     * @return string $link
     */
    public function getLink()
    {
        return $this->link;
    }

    /**
     * Setter for $link
     *
     * @param  string $link
     * @return UseCase
     */
    public function setLink($link)
    {
        $this->link = $link;
        return $this;
    }

    /**
     * Getter for $note
     *
     * @return string $note
     */
    public function getNote()
    {
        return $this->note;
    }

    /**
     * Setter for $note
     *
     * @param  string $note
     * @return UseCase
     */
    public function setNote($note)
    {
        $this->note = $note;
        return $this;
    }

    /**
     * Getter for $dependencies
     *
     * @return \Zend\Stdlib\ArrayObject $dependencies
     */
    public function getDependencies()
    {
        return $this->dependencies;
    }

    /**
     * Setter for $dependencies
     *
     * @param  \Zend\Stdlib\ArrayObject $dependencies
     * @return UseCase
     */
    public function setDependencies($dependencies)
    {
        $this->dependencies = $dependencies;
        return $this;
    }
    
    public function addDependencies($dependencies)
    {
        if ($dependencies instanceof ArrayCollection) {
            $entity = $dependencies->current();
            while ($entity) {
                $this->getDependencies()->add($entity);
                $entity = $dependencies->next();
            }
        } else {
            $this->getDependencies()->add($dependencies);
        }
        
        return $this;
    }
    
    public function removeDependencies($dependencies)
    {
        if ($dependencies instanceof ArrayCollection) {
            $entity = $dependencies->current();
            while ($entity) {
                $this->getDependencies()->remove($entity);
                $entity = $dependencies->next();
            }
        } else {
            $this->getDependencies()->remove($dependencies);
        }
    
        return $this;
    }

    /**
     * Getter for $usedByDependencies
     *
     * @return \Zend\Stdlib\ArrayObject $usedByDependencies
     */
    public function getUsedByDependencies()
    {
        return $this->usedByDependencies;
    }

    /**
     * Setter for $usedByDependencies
     *
     * @param  \Zend\Stdlib\ArrayObject $usedByDependencies
     * @return UseCase
     */
    public function setUsedByDependencies($usedByDependencies)
    {
        $this->usedByDependencies = $usedByDependencies;
        return $this;
    }

    /**
     * Returns the unique identifier of this node
     *
     * @return string
     */
    public function getNodeIdentifier()
    {
        return $this->getId();
    }
    
    /**
     * Returns the name of this node
     *
     * @return string
     */
    public function getNodeName()
    {
        /*$nodeName = $this->getType() ->getName()
                  . '-' 
                  . $this->getCategory()->getTitle() 
                  . '-' 
                  . $this->getName();*/
        
        return $this->getExtendedName();
    }
    
    /**
     * Returns the node type
     *
     * @return string $type
     */
    public function getNodeType()
    {
        return DiagrammNode::TYPE_USE_CASE;
    }

    /**
     * @ORM\PrePersist
     */
    public function onPrePersist()
    {
        parent::onPrePersist();
    }
    
    /**
     * @ORM\PreUpdate
     */
    public function onPreUpdate()
    {
        parent::onPreUpdate();
    }
}