<?php

namespace AppBundle\Faker\Provider;

use Faker\Generator;
use Faker\Provider\Base;
use AppBundle\Document\City as CityEntity;
use AppBundle\Document\Coordinates as CoordinatesEntity;

class City extends Base {

    public function __construct(Generator $generator, $cityStatus) {
        parent::__construct($generator);

        $this->generator = $generator;
        
        $this->cityStatus = $cityStatus;
    }

    /**
     * Get random city
     * 
     * @return CityEntity
     */
    public function objectCity() {

        $city = new CityEntity();
        $city->setName($this->generator->city());
        $city->setStatus($this->generator->randomElement($this->cityStatus));

        $coordinates = new CoordinatesEntity();
        $coordinates->setLongitude($this->generator->longitude());
        $coordinates->setLatitude($this->generator->latitude());
        

        $city->setCoordinates($coordinates);

        return $city;
    }

}
