<?php

namespace AppBundle\Document;

use Doctrine\ODM\MongoDB\Mapping\Annotations as ODM;

/**
 * AppBundle\Document\Station
 *
 * @ODM\Document(
 *     repositoryClass="AppBundle\Document\StationRepository"
 * )
 * @ODM\ChangeTrackingPolicy("DEFERRED_IMPLICIT")
 */
class Station
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
     * @var string $address
     *
     * @ODM\Field(name="address", type="string")
     */
    protected $address;

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
     * @var int $capacity
     *
     * @ODM\Field(name="capacity", type="int")
     */
    protected $capacity;

    /**
     * @var int $numberOfBikeAvailable
     *
     * @ODM\Field(name="numberOfBikeAvailable", type="int")
     */
    protected $numberOfBikeAvailable;

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
     * Set address
     *
     * @param string $address
     * @return self
     */
    public function setAddress($address)
    {
        $this->address = $address;
        return $this;
    }

    /**
     * Get address
     *
     * @return string $address
     */
    public function getAddress()
    {
        return $this->address;
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
     * Set capacity
     *
     * @param int $capacity
     * @return self
     */
    public function setCapacity($capacity)
    {
        $this->capacity = $capacity;
        return $this;
    }

    /**
     * Get capacity
     *
     * @return int $capacity
     */
    public function getCapacity()
    {
        return $this->capacity;
    }

    /**
     * Set numberOfBikeAvailable
     *
     * @param int $numberOfBikeAvailable
     * @return self
     */
    public function setNumberOfBikeAvailable($numberOfBikeAvailable)
    {
        $this->numberOfBikeAvailable = $numberOfBikeAvailable;
        return $this;
    }

    /**
     * Get numberOfBikeAvailable
     *
     * @return int $numberOfBikeAvailable
     */
    public function getNumberOfBikeAvailable()
    {
        return $this->numberOfBikeAvailable;
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
