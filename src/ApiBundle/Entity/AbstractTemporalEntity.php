<?php


namespace ApiBundle\Entity;


use Doctrine\ORM\Mapping as ORM;

/**
 * Governs all of the temporal entities of the system.
 * Will essentially ensure that Data Mappers objects contain a unique key with an
 * autoincrement ID and also Created at and Updated at attributes that will execute
 * using entity lifecycle events.
 *
 * @package CoreBundle\Entity
 * @author  Petre Pătrașc <petre@dreamlabs.ro>
 *
 * @ORM\MappedSuperclass
 * @ORM\HasLifecycleCallbacks
 */
abstract class AbstractTemporalEntity
{
    /**
     * @var int
     *
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @var \DateTime
     * @ORM\Column(type="datetime", name="created_at", nullable=true)
     */
    protected $createdAt;

    /**
     * @var \DateTime
     * @ORM\Column(type="datetime", name="updated_at", nullable=true)
     */
    protected $updatedAt;

    /**
     * @var bool
     *
     * @ORM\Column(name="deleted", type="boolean")
     */
    protected $deleted = false;

    /** @ORM\PrePersist */
    public function prePersistHook()
    {
        $this->setCreatedAt(new \DateTime());
        $this->setUpdatedAt(new \DateTime());
    }

    /** @ORM\PreUpdate */
    public function preUpdateHook()
    {
        $this->setUpdatedAt(new \DateTime());
    }

    /**
     * @param \DateTime $createdAt
     *
     * @return $this
     */
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;

        return $this->createdAt;
    }

    /**
     * @return \DateTime
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param \DateTime $updatedAt
     *
     * @return $this
     */
    public function setUpdatedAt($updatedAt)
    {
        $this->updatedAt = $updatedAt;

        return $this->updatedAt;
    }

    /**
     * @return \DateTime
     */
    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }

    /**
     * @return boolean
     */
    public function isDeleted()
    {
        return $this->deleted;
    }

    /**
     * @param boolean $deleted
     *
     * @return $this
     */
    public function setDeleted($deleted)
    {
        $this->deleted = $deleted;

        return $this;
    }


}
