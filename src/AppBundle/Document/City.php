<?php

namespace AppBundle\Document;

use Doctrine\ODM\MongoDB\Mapping\Annotations as ODM;

/**
 * AppBundle\Document\City
 *
 * @ODM\Document(
 *     repositoryClass="AppBundle\Document\CityRepository"
 * )
 * @ODM\ChangeTrackingPolicy("DEFERRED_IMPLICIT")
 */
class City
{
    /**
     * @var MongoId $id
     *
     * @ODM\Id(strategy="AUTO")
     */
    protected $id;

    /**
     * @var string $name
     *
     * @ODM\Field(name="name", type="string")
     */
    protected $name;

    /**
     * @var string $lat
     *
     * @ODM\Field(name="lat", type="string")
     */
    protected $lat;

    /**
     * @var string $long
     *
     * @ODM\Field(name="long", type="string")
     */
    protected $long;

    /**
     * @var string $status
     *
     * @ODM\Field(name="status", type="string")
     */
    protected $status;


    /**
     * Get id
     *
     * @return id $id
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set name
     *
     * @param string $name
     * @return self
     */
    public function setName($name)
    {
        $this->name = $name;
        return $this;
    }

    /**
     * Get name
     *
     * @return string $name
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set lat
     *
     * @param string $lat
     * @return self
     */
    public function setLat($lat)
    {
        $this->lat = $lat;
        return $this;
    }

    /**
     * Get lat
     *
     * @return string $lat
     */
    public function getLat()
    {
        return $this->lat;
    }

    /**
     * Set long
     *
     * @param string $long
     * @return self
     */
    public function setLong($long)
    {
        $this->long = $long;
        return $this;
    }

    /**
     * Get long
     *
     * @return string $long
     */
    public function getLong()
    {
        return $this->long;
    }

    /**
     * Set status
     *
     * @param string $status
     * @return self
     */
    public function setStatus($status)
    {
        $this->status = $status;
        return $this;
    }

    /**
     * Get status
     *
     * @return string $status
     */
    public function getStatus()
    {
        return $this->status;
    }
}
