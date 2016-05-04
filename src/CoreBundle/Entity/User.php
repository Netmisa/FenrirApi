<?php

namespace CoreBundle\Entity;

use FOS\UserBundle\Model\User as BaseUser;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * Users
 *
 * @ORM\Table(name="user")
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
     * @var BillingPlan
     *
     * @ORM\Column(name="billing_plan_id", nullable=false)
     * @ORM\ManyToOne(targetEntity="BillingPlan")
     * @ORM\JoinColumn(name="billing_plan_id")
     */
    private $billingPlan;

    /**
     * @var Origin
     *
     * @ORM\Column(name="origin_id", nullable=false)
     * @ORM\ManyToOne(targetEntity="Origin")
     * @ORM\JoinColumn(name="origin_id")
     */
    private $origin;

    /**
     * @var \DateTime
     *
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $blockUntil;

    /**
     * @var \Doctrine\Common\Collections\ArrayCollection
     *
     * @ORM\ManyToMany(targetEntity="Instance", inversedBy="users")
     * @ORM\JoinTable(name="users_instances")
     */
    private $instances;

    /**
     * @var AccessType
     *
     * @ORM\Column(name="access_type_id", nullable=false)
     * @ORM\ManyToOne(targetEntity="AccessType")
     * @ORM\JoinColumn(name="access_type_id")
     */
    private $accessType;

    /**
     * @var \Doctrine\Common\Collections\ArrayCollection
     *
     * @ORM\ManyToOne(targetEntity="Key")
     * @ORM\JoinTable(name="users_keys",
     *      joinColumns={@ORM\JoinColumn(name="user_id")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="key_id", unique=true)}
     *      )
     */
    private $keys;

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
    * Gets the value of billingPlan.
    *
    * @return BillingPlan
    */
    public function getBillingPlan()
    {
        return $this->billingPlan;
    }

    /**
    * Sets the value of billingPlan.
    *
    * @param BillingPlan $billingPlan the billing plan
    *
    * @return self
    */
    public function setBillingPlan(BillingPlan $billingPlan)
    {
        $this->billingPlan = $billingPlan;

        return $this;
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
    * Sets the value of blockUntil.
    *
    * @param \DateTime $blockUntil the block until
    *
    * @return self
    */
    public function setBlockUntil(\DateTime $blockUntil)
    {
        $this->blockUntil = $blockUntil;

        return $this;
    }

    /**
    * Gets the value of instances.
    *
    * @return \Doctrine\Common\Collections\ArrayCollection
    */
    public function getInstances()
    {
        return $this->instances;
    }

    /**
    * Sets the value of instances.
    *
    * @param \Doctrine\Common\Collections\ArrayCollection $instances the instances
    *
    * @return self
    */
    public function setInstances(\Doctrine\Common\Collections\ArrayCollection $instances)
    {
        $this->instances = $instances;

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

    /**
    * Gets the value of keys
    *
    * @return \Doctrine\Common\Collections\ArrayCollection
    */
    public function getKeys()
    {
        return $this->keys;
    }

    /**
    * Sets the value of keys
    *
    * @param \Doctrine\Common\Collections\ArrayCollection $keys the keys
    *
    * @return self
    */
    public function setKeys(\Doctrine\Common\Collections\ArrayCollection $keys)
    {
        $this->keys = $keys;

        return $this;
    }

    /**
    * Gets the value of accessType.
    *
    * @return AccessType
    */
    public function getAccessType()
    {
        return $this->accessType;
    }

    /**
    * Sets the value of accessType.
    *
    * @param AccessType $accessType the access type
    *
    * @return self
    */
    public function setAccessType(AccessType $accessType)
    {
        $this->accessType = $accessType;

        return $this;
    }
}
