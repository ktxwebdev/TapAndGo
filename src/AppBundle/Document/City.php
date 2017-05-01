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
 * 
 * @ODM\Index(keys={"coordinates"="2d"})
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

    /** @ODM\EmbedOne(targetDocument="AppBundle\Document\Coordinates") */
    public $coordinates;

    /**
     * @var string $status
     *
     * @ODM\Field(name="status", type="string")
     */
    protected $status;
    
    /**
     * @var array $stations
     *
     * @ODM\ReferenceMany(targetDocument="AppBundle\Document\Station", simple=true)
     */
    protected $stations;
    
    public function __construct()
    {
        $this->stations = new \Doctrine\Common\Collections\ArrayCollection();
    }

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
     * Set coordinates
     *
     * @param AppBundle\Document\Coordinates $coordinates
     * @return self
     */
    public function setCoordinates(\AppBundle\Document\Coordinates $coordinates)
    {
        $this->coordinates = $coordinates;
        return $this;
    }

    /**
     * Get coordinates
     *
     * @return AppBundle\Document\Coordinates $coordinates
     */
    public function getCoordinates()
    {
        return $this->coordinates;
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

    /**
     * Add station
     *
     * @param AppBundle\Document\Station $station
     */
    public function addStation(\AppBundle\Document\Station $station)
    {
        $this->stations[] = $station;
    }

    /**
     * Remove station
     *
     * @param AppBundle\Document\Station $station
     */
    public function removeStation(\AppBundle\Document\Station $station)
    {
        $this->stations->removeElement($station);
    }

    /**
     * Get stations
     *
     * @return \Doctrine\Common\Collections\Collection $stations
     */
    public function getStations()
    {
        return $this->stations;
    }
}
