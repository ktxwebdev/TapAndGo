<?php

namespace AppBundle\Security\User;

use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\Security\Core\User\UserProviderInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\Exception\UsernameNotFoundException;
use Symfony\Component\Security\Core\Exception\UnsupportedUserException;

use UserBundle\Entity\WebserviceUser;

class WebserviceUserProvider implements UserProviderInterface
{
    /**
     * Construct
     *
     * @param ContainerInterface $container
     */
    public function __construct($container, $securityEncodersAlgorithm)
    {
        $this->container = $container;
        $this->request = $container->get('request');
        $this->securityEncodersAlgorithm = $securityEncodersAlgorithm;
    }

    public function loadUserByUsername($username)
    {
        /* Init the user to false */
        $user = false;

        try {
            /* Try to find the user with the username or the email */
            $user = $this->container->get('user_api.user')->getUser($username);
        } catch (\Exception $e) {
            /* Throw an error not ofund in case of error */
            throw new UsernameNotFoundException(sprintf('Username "%s" does not exist.', $username));
        }

        if (!($user instanceof WebserviceUser)) {
            throw new \Exception($user);
        } else {
            return $user;
        }
    }

    public function refreshUser(UserInterface $user)
    {
        if (!$user instanceof WebserviceUser) {
            throw new UnsupportedUserException(sprintf('Instances of "%s" are not supported.', get_class($user)));
        }

        return $this->loadUserByUsername($user->getUsername());
    }

    public function supportsClass($class)
    {
        return $class === 'UserBundle\Entity\WebserviceUser';
    }
}
