<?php

namespace AppBundle\DataFixtures\MongoDB;

use AppBundle\DataFixtures\FixturesHelper;
use AppBundle\Document\City;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;

class LoadCityData extends AbstractFixture implements OrderedFixtureInterface, FixtureInterface, ContainerAwareInterface {

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
        $this->faker->addProvider($this->container->get('app.faker.city'));
    }

    /**
     * {@inheritDoc}
     */
    public function load(ObjectManager $manager) {

        for ($i = 0; $i <= 100; $i++) {
            $city = $this->faker->objectCity();

            $manager->persist($city->getCoordinates());
            $manager->persist($city);

            $this->addReference('city-' . $i, $city);
        }

        $manager->flush();
    }

    /**
     * {@inheritDoc}
     */
    public function getOrder() {
        return 2000;
    }

}
