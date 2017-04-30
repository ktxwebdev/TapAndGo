<?php

namespace AppBundle\DataFixtures\MongoDB;

use AppBundle\Document\User;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\DependencyInjection\ContainerAwareInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
//use Application\Sonata\MediaBundle\Entity\Media;

/**
 * LoadUserData
 */
class LoadUserData extends AbstractFixture implements OrderedFixtureInterface, FixtureInterface, ContainerAwareInterface
{

    /**
     * @var ContainerInterface
     */
    private $container;

    /**
     * {@inheritDoc}
     */
    public function setContainer(ContainerInterface $container = null)
    {
        $this->container = $container;
        $this->faker = \Faker\Factory::create('fr_FR');
        $this->userManager = $this->container->get('fos_user.user_manager');
        $this->tokenGenerator = $this->container->get('fos_user.util.token_generator');
    }

    /**
     * Load
     *
     * @param ObjectManager $manager
     *
     * @return string
     */
    public function load(ObjectManager $manager)
    {
        $generator = \Faker\Factory::create('fr_FR');

        /* Add the user ADMIN */
        /** @var User $admin */
        $admin = $this->userManager->createUser();
        $admin->setUsername('admin');
        $admin->setEmail('admin@admin.fr');
        $admin->setEnabled(true);
        $admin->isCredentialsNonExpired(false);
        $admin->setRoles(['ROLE_SUPER_ADMIN']);
        $admin->setConfirmationToken(null);
        $admin->setPlainPassword('admin');

        $this->addReference('user-admin', $admin);

        $this->userManager->updateUser($admin);
//
//        /* Add some users */
//        $populator->addEntity(
//            'AppBundle:User', $this->nbUserCreate, array(
//            'username' => function () use ($generator) {
//                return $generator->name().'_'.$generator->randomNumber();
//            },
//            'email' => function () use ($generator) {
//                return $generator->email();
//            },
//            'phoneNumber' => function () use ($generator) {
//                return $generator->phoneNumber();
//            },
//            'portableNumber' => function () use ($generator) {
//                return $generator->phoneNumber();
//            },
//            'nbConnections' => function () use ($generator) {
//                return $generator->numberBetween(0, 100);
//            },
//            'loginAttempt' => function () use ($generator) {
//                return $generator->numberBetween(0, 3);
//            },
//            'enabled' => true,
//            'locked' => function () use ($generator) {
//                return $generator->boolean();
//            },
//            'expiresAt' => function () use ($generator) {
//                return $generator->dateTimeBetween('now', '+3 years');
//            },
//            'credentialsExpireAt' => function () use ($generator) {
//                return $generator->dateTimeBetween('now', '+3 years');
//            },
//            'group' => function () use ($generator) {
//                return $this->getReference('group-'.$generator->numberBetween(0, $this->nbGroupCreate - 1));
//            },
//            'roles' => array('ROLE_USER'),
//        ), array(
//            function ($user) {
//                $user->setPlainPassword('test');
//            },
//        )
//        );
//
//        $execute = $populator->execute();
//
//        foreach ($execute['AppBundle\Document\User'] as $key => $entity) {
//            $this->addReference('user-'.$key, $entity);
//        }
    }

    /**
     * {@inheritDoc}
     */
    public function getOrder()
    {
        return 1000;
    }
}
