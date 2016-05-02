<?php

namespace CoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * Instance
 *
 * @ORM\Table(name="instance")
 * @ORM\Entity(repositoryClass="CoreBundle\Repository\InstanceRepository")
 */
class Instance
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
     * @var bool
     *
     * @ORM\Column(name="is_free", type="boolean")
     */
    private $isFree;

    /**
     * @var \Doctrine\Common\Collections\ArrayCollection
     *
     * @ORM\ManyToMany(targetEntity="User", mappedBy="instances")
     */
    private $users;

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

    public function __construct() {
        $this->users = new \Doctrine\Common\Collections\ArrayCollection();
    }

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
     * @return Instance
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
     * Set isFree
     *
     * @param boolean $isFree
     *
     * @return Instance
     */
    public function setIsFree($isFree)
    {
        $this->isFree = $isFree;

        return $this;
    }

    /**
     * Get isFree
     *
     * @return bool
     */
    public function getIsFree()
    {
        return $this->isFree;
    }

    /**
    * Gets the value of users.
    *
    * @return ArrayCollection
    */
    public function getUsers()
    {
        return $this->users;
    }

    /**
    * Sets the value of users.
    *
    * @param ArrayCollection $users the users
    *
    * @return self
    */
    public function setUsers(\Doctrine\Common\Collections\ArrayCollection $users)
    {
        $this->users = $users;

        return $this;
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
