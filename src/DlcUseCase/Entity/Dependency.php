<?php
namespace DlcUseCase\Entity;

use DlcDiagramm\Diagramm\Dependency as DiagrammDependency;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * The use case dependency entity
 *
 * @ORM\Entity
 * @ORM\Table(name="use_case_dependencies")
 */
class Dependency extends DiagrammDependency
{
    /**
     * @ORM\Id @ORM\Column(type="integer")
     * @ORM\GeneratedValue
     * @var int
     */
    protected $id;
    
    /**
     * @ORM\ManyToOne(targetEntity="UseCase", inversedBy="dependenciesFrom")
     * @ORM\JoinColumn(name="from_use_case_id", referencedColumnName="id")
     * @var UseCase
     */
    protected $fromNode;
    
    /**
     * @ORM\ManyToOne(targetEntity="UseCase", inversedBy="dependenciesTo")
     * @ORM\JoinColumn(name="to_use_case_id", referencedColumnName="id")
     * @var UseCase
     */
    protected $toNode;
    
    /**
     * Dependency type
     *
     * @ORM\Column(type="string",length=100,unique=false)
     * @var string
     */
    protected $type;
    
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
     * @return Dependency
     */
    public function setId($id)
    {
        $this->id = $id;
        return $this;
    }

    
    
}