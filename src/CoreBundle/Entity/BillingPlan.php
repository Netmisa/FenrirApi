<?php

namespace CoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * BillingPlan
 *
 * @ORM\Table(name="billing_plan")
 * @ORM\Entity(repositoryClass="CoreBundle\Repository\BillingPlanRepository")
 */
class BillingPlan
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
     * @ORM\Column(name="name", type="string")
     */
    private $name;

    /**
     * @var bool
     *
     * @ORM\Column(name="default", type="boolean")
     */
    private $default;

    /**
     * @var int
     *
     * @ORM\Column(name="max_object_count", type="integer")
     */
    private $maxObjectCount;

    /**
     * @var int
     *
     * @ORM\Column(name="max_request_count", type="integer")
     */
    private $maxRequestCount;

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
     * @return BillingPlan
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
     * Set default
     *
     * @param boolean $default
     *
     * @return BillingPlan
     */
    public function setDefault($default)
    {
        $this->default = $default;

        return $this;
    }

    /**
     * Get default
     *
     * @return bool
     */
    public function getDefault()
    {
        return $this->default;
    }

    /**
     * Set maxObjectCount
     *
     * @param integer $maxObjectCount
     *
     * @return BillingPlan
     */
    public function setMaxObjectCount($maxObjectCount)
    {
        $this->maxObjectCount = $maxObjectCount;

        return $this;
    }

    /**
     * Get maxObjectCount
     *
     * @return int
     */
    public function getMaxObjectCount()
    {
        return $this->maxObjectCount;
    }

    /**
     * Set maxRequestCount
     *
     * @param integer $maxRequestCount
     *
     * @return BillingPlan
     */
    public function setMaxRequestCount($maxRequestCount)
    {
        $this->maxRequestCount = $maxRequestCount;

        return $this;
    }

    /**
     * Get maxRequestCount
     *
     * @return int
     */
    public function getMaxRequestCount()
    {
        return $this->maxRequestCount;
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
