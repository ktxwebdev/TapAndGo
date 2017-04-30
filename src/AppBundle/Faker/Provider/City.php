<?php

namespace AppBundle\Faker\Provider;

use Faker\Generator;
use Faker\Provider\Base;
use AppBundle\Document\City as CityEntity;

class City extends Base {

    public function __construct(Generator $generator) {
        parent::__construct($generator);

        $this->generator = $generator;
        
    }

    /**
     * Get random city
     * 
     * @return CityEntity
     */
    public function objectCity() {

        $city = new CityEntity();
        $city->setName($this->generator->city());
        $city->setLat($this->generator->latitude());
        $city->setLong($this->generator->longitude());

        return $city;
    }
}
