<?php

namespace AppBundle\DataFixtures\MongoDB;

use AppBundle\DataFixtures\FixturesHelper;
use AppBundle\Document\Station;
use AppBundle\Document\City;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;

class LoadStationData extends AbstractFixture implements OrderedFixtureInterface, FixtureInterface, ContainerAwareInterface {

    /**
     * @var ContainerInterface
     */
    private $container;

    /**
     * {@inheritDoc}
     */
    public function setContainer(ContainerInterface $container = null) {
        $this->container = $container;
        $this->faker = \Faker\Factory::create('fr_FR');
        $this->faker->addProvider($this->container->get('app.faker.station'));
    }

    /**
     * {@inheritDoc}
     */
    public function load(ObjectManager $manager) {

        $cityReference = 0;
        $stationReference = 0;
        while ($this->hasReference('city-' . $cityReference)) {
            
            $city = $this->getReference('city-' . $cityReference);

            for ($i = 0; $i <= $this->faker->numberBetween(0, 15); $i++) {
                $station = $this->faker->station();
                
                $city->addStation($station);

                $manager->persist($station);
                $manager->persist($city);

                $this->addReference('station-' . $stationReference, $station);
                $stationReference++;
            }

            $manager->flush();

            $cityReference++;
        }
    }

    /**
     * {@inheritDoc}
     */
    public function getOrder() {
        return 5000;
    }

}
