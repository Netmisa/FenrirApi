<?php

namespace CoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * AccessType
 *
 * @ORM\Table(name="access_type")
 * @ORM\Entity(repositoryClass="CoreBundle\Repository\AccessTypeRepository")
 */
class AccessType
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255, unique=true)
     */
    private $name;

    /**
     * @var \Datetime
     *
     * @Gedmo\Timestampable(on="created_at")
     * @ORM\Column(type="datetime")
     */
    private $createdAt;

    /**
     * @var \Datetime
     *
     * @ORM\Column(type="datetime")
     * @Gedmo\Timestampable(on="updated_at")
     */
    private $updatedAt;

    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set name
     *
     * @param string $name
     *
     * @return AccessType
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
    * Gets the value of createdAt.
    *
    * @return \Datetime
    */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
    * Sets the value of createdAt.
    *
    * @param \Datetime $createdAt the created at
    *
    * @return self
    */
    public function setCreatedAt(\Datetime $createdAt)
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    /**
    * Gets the value of updatedAt.
    *
    * @return \Datetime
    */
    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }

    /**
    * Sets the value of updatedAt.
    *
    * @param \Datetime $updatedAt the updated at
    *
    * @return self
    */
    public function setUpdatedAt(\Datetime $updatedAt)
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }
}

