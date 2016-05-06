<?php

namespace CoreBundle\Entity;

use FOS\UserBundle\Model\User as BaseUser;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * Users
 *
 * @ORM\Table(name="t_user")
 * @ORM\Entity(repositoryClass="CoreBundle\Repository\UserRepository")
 * @ORM\AttributeOverrides({
 *      @ORM\AttributeOverride(name="email", column=@ORM\Column(nullable = true)),
 *      @ORM\AttributeOverride(name="emailCanonical",
 *          column=@ORM\Column(
 *              nullable = true,
 *              unique   = false
 *          )
 *      ),
 *      @ORM\AttributeOverride(name="salt", column=@ORM\Column(nullable = true)),
 *      @ORM\AttributeOverride(name="password", column=@ORM\Column(nullable = true)),
 * })
 *
 */
class User extends BaseUser
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @var \Datetime
     *
     * @ORM\Column(type="datetime")
     * @Gedmo\Timestampable(on="create")
     */
    private $createdAt;

    /**
     * @var \Datetime
     *
     * @ORM\Column(type="datetime")
     * @Gedmo\Timestampable(on="update")
     */
    private $updatedAt;

    public function __construct()
    {
        parent::__construct();
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
