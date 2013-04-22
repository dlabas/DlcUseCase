<?php
namespace DlcUseCase\Entity;

use DlcDoctrine\Entity\AbstractProvidesHistoryEntity;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * The use case priority entity
 *
 * @ORM\Entity
 * @ORM\HasLifecycleCallbacks
 * @ORM\Table(name="use_case_priorities")
 */
class Priority extends AbstractProvidesHistoryEntity
{
    /**
     * @ORM\Id @ORM\Column(type="integer")
     * @ORM\GeneratedValue
     * @var int
     */
    protected $id;
    
    /**
     * @ORM\Column(type="string",length=100)
     * @var string
     */
    protected $name;
    
    /**
     * @ORM\OneToMany(targetEntity="UseCase", mappedBy="priority")
     * ævar ArrayCollection
     */
    protected $useCases;
    
    public function __construct()
    {
        $this->useCases = new ArrayCollection();
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
     * @return UseCaseType
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
     * @return UseCaseType
     */
    public function setName($name)
    {
        $this->name = $name;
        return $this;
    }

	/**
     * Getter for $useCases
     *
     * @return \Doctrine\Common\Collections\ArrayCollection $useCases
     */
    public function getUseCases()
    {
        return $this->useCases;
    }

	/**
     * Setter for $useCases
     *
     * @param  \Doctrine\Common\Collections\ArrayCollection $useCases
     * @return UseCaseType
     */
    public function setUseCases($useCases)
    {
        $this->useCases = $useCases;
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