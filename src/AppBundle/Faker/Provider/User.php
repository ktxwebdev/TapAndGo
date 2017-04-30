<?php

namespace AppBundle\Faker\Provider;

use Faker\Generator;
use Faker\Provider\Base;

use FOS\UserBundle\Doctrine\UserManager;

class User extends Base
{
    public function __construct(Generator $generator, UserManager $userManager)
    {
        parent::__construct($generator);

        $this->userManager = $userManager;

        $this->generator = $generator;
    }

    /**
     * Get Random User
     *
     * @return \UserBundle\Entity\User
     */
    public function user()
    {
        /** @var \UserBundle\Entity\User $user */
        $user = $this->userManager->createUser();
        $user->setUsername($this->generator->name);
        $user->setEmail($this->generator->email);
        $user->setFirstName($this->generator->firstName);
        $user->setLastName($this->generator->lastName);

        $this->userManager->updateUser($user, false);

        return $user;
    }
}