<?php

namespace ApiBundle\Entity;

use FOS\UserBundle\Model\User as BaseUser;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * Users.
 *
 * @ORM\Table(name="t_user", uniqueConstraints={@ORM\UniqueConstraint(name="username_canonical_origin_id", columns={"username_canonical", "origin_id"})})
 * @ORM\Entity(repositoryClass="ApiBundle\Repository\UserRepository")
 * @ORM\AttributeOverrides({
 *      @ORM\AttributeOverride(name="usernameCanonical", column=@ORM\Column(unique = false)),
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
     * @var Origin
     *
     * @ORM\ManyToOne(targetEntity="ApiBundle\Entity\Origin")
     * @ORM\JoinColumn(name="origin_id", referencedColumnName="id", nullable=false)
     */
    private $origin;

    /**
     * Whether this user is an internal user,
     * and api usage statistics should not be billed.
     *
     * @var bool
     *
     * @ORM\Column(type="boolean")
     */
    private $isInternal;

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

    /**
     * Get id.
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Gets the value of origin.
     *
     * @return Origin
     */
    public function getOrigin()
    {
        return $this->origin;
    }

    /**
     * Sets the value of origin.
     *
     * @param Origin $origin the origin
     *
     * @return self
     */
    public function setOrigin(Origin $origin)
    {
        $this->origin = $origin;

        return $this;
    }

    /**
     * @return bool
     */
    public function isInternal()
    {
        return $this->isInternal;
    }

    /**
     * @param bool $isInternal
     *
     * @return self
     */
    public function setInternal($isInternal)
    {
        $this->isInternal = $isInternal;

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
