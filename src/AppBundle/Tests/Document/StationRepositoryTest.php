<?php

namespace AppBundle\Tests\Document;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

/**
 * StationRepositoryTest
 */
class StationRepositoryTest extends WebTestCase {

    public function setup() {
        static::$kernel = static::createKernel();
        static::$kernel->boot();

        $this->container = static::$kernel->getContainer();

        $this->faker = \Faker\Factory::create('fr_FR');
    }

    public function testGetStationListNearApi() {

        $stationRepository = $this->container->get('doctrine_mongodb')->getManager()->getRepository('AppBundle:Station');

        $lat = 10;
        $lng = 20;
        $radius = $this->faker->randomDigitNotNull();
        $radius = 10;

        $listStationNear = $stationRepository->getStationListNearApi($lat, $lng, $radius, 10);

        dump($listStationNear);
        die('lksdjflskdjf');
    }

}
