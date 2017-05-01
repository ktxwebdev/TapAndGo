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
 * 
 * @ODM\Index(keys={"coordinates"="2d"})
 */
class Station {

    const STATUS_ACTIVATED = 'status.activated';
    const STATUS_DESACTIVATED = 'status.desactivated';

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
     * @var string $description
     *
     * @ODM\Field(type="string")
     */
    protected $description;

    /**
     * @var string $address
     *
     * @ODM\Field(name="address", type="string")
     */
    protected $address;

    /**
     * @var string $latitude
     *
     * @ODM\Field(type="float")
     */
    protected $latitude;

    /**
     * @var string $longitude
     *
     * @ODM\Field(type="float")
     */
    protected $longitude;

    /** @ODM\EmbedOne(targetDocument="AppBundle\Document\Coordinates") */
    public $coordinates;

    /**
     * @var int $bikesCapacity
     *
     * @ODM\Field(type="int")
     */
    protected $bikesCapacity;

    /**
     * @var int $bikesAvailable
     *
     * @ODM\Field(type="int")
     */
    protected $bikesAvailable;

    /**
     * @var string $status
     *
     * @ODM\Field(name="status", type="string")
     */
    protected $status;

    /**
     * @var array $stations
     *
     * @ODM\ReferenceOne(targetDocument="AppBundle\Document\City", simple=true)
     */
    protected $city;

    /**
     * @var string $creationDate
     *
     * @ODM\Field(type="date")
     */
    protected $creationDate;

    /**
     * @var string $lastUpdate
     *
     * @ODM\Field(type="date")
     */
    protected $lastUpdate;

    public function __construct() {

        $dateNow = new \DateTime();

        $this->setCreationDate($dateNow);
        $this->setLastUpdate($dateNow);
    }

    public function __toString() {
        return $this->getName();
    }

    /**
     * Get id
     *
     * @return id $id
     */
    public function getId() {
        return $this->id;
    }

    /**
     * Set name
     *
     * @param string $name
     * @return self
     */
    public function setName($name) {
        $this->name = $name;
        return $this;
    }

    /**
     * Get name
     *
     * @return string $name
     */
    public function getName() {
        return $this->name;
    }

    /**
     * Set description
     *
     * @param string $description
     * @return self
     */
    public function setDescription($description) {
        $this->description = $description;
        return $this;
    }

    /**
     * Get description
     *
     * @return string $description
     */
    public function getDescription() {
        return $this->description;
    }

    /**
     * Set address
     *
     * @param string $address
     * @return self
     */
    public function setAddress($address) {
        $this->address = $address;
        return $this;
    }

    /**
     * Get address
     *
     * @return string $address
     */
    public function getAddress() {
        return $this->address;
    }

    /**
     * Set latitude
     *
     * @param float $latitude
     * @return self
     */
    public function setLatitude($latitude) {
        $this->latitude = $latitude;
        return $this;
    }

    /**
     * Get latitude
     *
     * @return float $latitude
     */
    public function getLatitude() {
        return $this->latitude;
    }

    /**
     * Set longitude
     *
     * @param float $longitude
     * @return self
     */
    public function setLongitude($longitude) {
        $this->longitude = $longitude;
        return $this;
    }

    /**
     * Get longitude
     *
     * @return float $longitude
     */
    public function getLongitude() {
        return $this->longitude;
    }

    /**
     * Set coordinates
     *
     * @param AppBundle\Document\Coordinates $coordinates
     * @return self
     */
    public function setCoordinates(\AppBundle\Document\Coordinates $coordinates) {
        $this->coordinates = $coordinates;
        return $this;
    }

    /**
     * Get coordinates
     *
     * @return AppBundle\Document\Coordinates $coordinates
     */
    public function getCoordinates() {
        return $this->coordinates;
    }

    /**
     * Set bikesCapacity
     *
     * @param int $bikesCapacity
     * @return self
     */
    public function setBikesCapacity($bikesCapacity) {
        $this->bikesCapacity = $bikesCapacity;
        return $this;
    }

    /**
     * Get bikesCapacity
     *
     * @return int $bikesCapacity
     */
    public function getBikesCapacity() {
        return $this->bikesCapacity;
    }

    /**
     * Set bikesAvailable
     *
     * @param int $bikesAvailable
     * @return self
     */
    public function setBikesAvailable($bikesAvailable) {
        $this->bikesAvailable = $bikesAvailable;
        return $this;
    }

    /**
     * Get bikesAvailable
     *
     * @return int $bikesAvailable
     */
    public function getBikesAvailable() {
        return $this->bikesAvailable;
    }

    /**
     * Set status
     *
     * @param string $status
     * @return self
     */
    public function setStatus($status) {
        $this->status = $status;
        return $this;
    }

    /**
     * Get status
     *
     * @return string $status
     */
    public function getStatus() {
        return $this->status;
    }

    /**
     * Set city
     *
     * @param AppBundle\Document\City $city
     * @return self
     */
    public function setCity(\AppBundle\Document\City $city) {
        $this->city = $city;
        return $this;
    }

    /**
     * Get city
     *
     * @return AppBundle\Document\City $city
     */
    public function getCity() {
        return $this->city;
    }

    /**
     * Set creationDate
     *
     * @param date $creationDate
     * @return self
     */
    public function setCreationDate($creationDate) {
        $this->creationDate = $creationDate;
        return $this;
    }

    /**
     * Get creationDate
     *
     * @return date $creationDate
     */
    public function getCreationDate() {
        return $this->creationDate;
    }

    /**
     * Set lastUpdate
     *
     * @param date $lastUpdate
     * @return self
     */
    public function setLastUpdate($lastUpdate) {
        $this->lastUpdate = $lastUpdate;
        return $this;
    }

    /**
     * Get lastUpdate
     *
     * @return date $lastUpdate
     */
    public function getLastUpdate() {
        return $this->lastUpdate;
    }

}
