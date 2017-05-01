<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

/**
 * Description of DefaultController
 *
 * @author Cyril
 */
class DefaultController extends Controller {

    /**
     * Redirect to login page
     *
     * @Route("/", name="root")
     *
     * @return array
     */
    public function indexAction() {

        if (is_null($this->getUser())) {
            return $this->redirectToRoute('fos_user_security_login');
        } else {
            return $this->redirectToRoute('city');
        }
    }

}
