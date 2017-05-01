<?php

namespace AppBundle\Faker\Provider;

use Faker\Generator;
use Faker\Provider\Base;
use AppBundle\Document\Station as StationEntity;
use AppBundle\Document\Coordinates as CoordinatesEntity;

class Station extends Base {

    public function __construct(Generator $generator, $stationStatus) {
        parent::__construct($generator);

        $this->generator = $generator;

        $this->stationStatus = $stationStatus;
    }

    /**
     * Get random station
     * 
     * @return StationEntity
     */
    public function station() {

        $capacity = $this->generator->numberBetween(10, 30);

        $station = new StationEntity();
        $station->setName($this->generator->streetName());
        $station->setDescription($this->generator->text());
        $station->setAddress($this->generator->streetAddress());
        $station->setBikesCapacity($capacity);
        $station->setBikesAvailable($this->generator->numberBetween(0, $capacity));
        $station->setStatus($this->generator->randomElement($this->stationStatus));

        $coordinates = new CoordinatesEntity();
        $coordinates->setLongitude($this->generator->longitude());
        $coordinates->setLatitude($this->generator->latitude());

        $station->setCoordinates($coordinates);

        return $station;
    }

}
