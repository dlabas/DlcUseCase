<?php
namespace DlcUseCase\Entity;

use DlcDiagramm\Diagramm\Dependency\DependencyInterface;
use DlcDiagramm\Diagramm\Node as DiagrammNode;
use DlcDiagramm\Diagramm\Node\NodeInterface as DiagrammNodeInterface;
use DlcDiagramm\Diagramm\NoteProviderInterface;
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
class UseCase extends AbstractProvidesHistoryEntity implements DiagrammNodeInterface, NoteProviderInterface
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
     * Optional field: category
     *
     * @ORM\ManyToOne(targetEntity="DlcCategory\Entity\CategoryInterface")
     * @ORM\JoinColumn(name="category_id", referencedColumnName="id")
     * @var \DlcCategory\Entity\Category
     */
    protected $category;

    /**
     * Optional field: priority
     *
     * @ORM\ManyToOne(targetEntity="Priority")
     * @ORM\JoinColumn(name="priority_id", referencedColumnName="id")
     * @var Priority
     */
    protected $priority;

    /**
     * Optional field: link
     *
     * @ORM\Column(type="string",nullable=true)
     * @var string
     */
    protected $link;

    /**
     * Optional field: note
     *
     * @ORM\Column(type="string",nullable=true)
     * @var string
     */
    protected $note;

    /**
     * Optional field: description
     *
     * @ORM\Column(type="text",nullable=true)
     * @var string
     */
    protected $description;

    /**
     * Optional field: details
     *
     * @ORM\Column(type="text",nullable=true)
     * @var string
     */
    protected $details;

    /**
     * Optional field: comment
     *
     * @ORM\Column(type="text",nullable=true)
     * @var string
     */
    protected $comment;

    /**
     * Optional field: input data
     *
     * @ORM\Column(name="input_data",type="text",nullable=true)
     * @var string
     */
    protected $inputData;

    /**
     * Optional field: output data
     *
     * @ORM\Column(name="output_data",type="text",nullable=true)
     * @var string
     */
    protected $outputData;

    /**
     * Dependencies of this node
     *
     * @ORM\OneToMany(targetEntity="Dependency", mappedBy="fromNode", cascade={"persist"}, orphanRemoval=true)
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
     * Generated wiki page
     *
     * @var string
     */
    protected $generatedWikiPage;

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
        $extendedName = $this->getType()->getName();

        $catTitle = $this->getCategoryTitle();
        if ($catTitle !== null) {
            $extendedName .= '-' . $this->getCategoryTitle();
        }

        $extendedName .= '-' . $this->getName();

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
     * Returns the title of it's category or null if category is not set
     *
     * @return NULL|string
     */
    public function getCategoryTitle()
    {
        $cat = $this->getCategory();

        if (null === $cat) {
            return null;
        }

        return $cat->getTitle();
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
     * Returns the name of it's priority or null if priority is not set
     *
     * @return NULL|string
     */
    public function getPriorityName()
    {
        $priority = $this->getPriority();

        if (null === $priority) {
            return null;
        }

        return $priority->getName();
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
     * Returns an note
     *
     * @return string
     */
    public function getNote()
    {
        return $this->note;
    }

    /**
     * Returns the background color of this note
     *
     * @return string
     */
    public function getNoteBg()
    {
        return NoteProviderInterface::BG_BEIGE;
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
     * Getter for $description
     *
     * @return string $description
     */
    public function getDescription ()
    {
        return $this->description;
    }

    /**
     * Setter for $description
     *
     * @param  string $description
     * @return UseCase
     */
    public function setDescription ($description)
    {
        $this->description = $description;
        return $this;
    }

    /**
     * Getter for $details
     *
     * @return string $details
     */
    public function getDetails ()
    {
        return $this->details;
    }

    /**
     * Setter for $details
     *
     * @param  string $details
     * @return UseCase
     */
    public function setDetails ($details)
    {
        $this->details = $details;
        return $this;
    }

    /**
     * Getter for $comment
     *
     * @return string $comment
     */
    public function getComment ()
    {
        return $this->comment;
    }

    /**
     * Setter for $comment
     *
     * @param  string $comment
     * @return UseCase
     */
    public function setComment ($comment)
    {
        $this->comment = $comment;
        return $this;
    }

    /**
     * Getter for $inputData
     *
     * @return string $inputData
     */
    public function getInputData ()
    {
        return $this->inputData;
    }

    /**
     * Setter for $inputData
     *
     * @param  string $inputData
     * @return UseCase
     */
    public function setInputData ($inputData)
    {
        $this->inputData = $inputData;
        return $this;
    }

    /**
     * Getter for $outputData
     *
     * @return string $outputData
     */
    public function getOutputData ()
    {
        return $this->outputData;
    }

    /**
     * Setter for $outputData
     *
     * @param  string $outputData
     * @return UseCase
     */
    public function setOutputData ($outputData)
    {
        $this->outputData = $outputData;
        return $this;
    }

    /**
     * Getter for $dependencies
     *
     * @return \Doctrine\Common\Collections\ArrayCollection $dependencies
     */
    public function getDependencies()
    {
        return $this->dependencies;
    }

    /**
     * Setter for $dependencies
     *
     * @param  \Doctrine\Common\Collections\ArrayCollection $dependencies
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
                if (!$this->getDependencies()->removeElement($entity)) {
                    throw new \RuntimeException('Error while removing a dependency');
                }
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
     * Getter for $generatedWikiPage
     *
     * @return string $generatedWikiPage
     */
    public function getGeneratedWikiPage()
    {
        return $this->generatedWikiPage;
    }

    /**
     * Setter for $generatedWikiPage
     *
     * @param  string $generatedWikiPage
     * @return UseCase
     */
    public function setGeneratedWikiPage($generatedWikiPage)
    {
        $this->generatedWikiPage = $generatedWikiPage;
        return $this;
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