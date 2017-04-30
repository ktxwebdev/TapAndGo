<?php

namespace AppBundle\Faker\Provider;

use Faker\Generator;
use Faker\Provider\Base;
use AppBundle\Document\Station as StationEntity;

class Station extends Base {

    public function __construct(Generator $generator) {
        parent::__construct($generator);

        $this->generator = $generator;
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
        $station->setLat($this->generator->latitude());
        $station->setLong($this->generator->longitude());
        $station->setAddress($this->generator->streetAddress());
        $station->setCapacity($this->generator->longitude());
        $station->setNumberOfBikeAvailable($this->generator->numberBetween(0, $capacity));

        return $station;
    }
}
