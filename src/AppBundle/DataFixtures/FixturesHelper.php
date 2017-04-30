<?php
/**
 * Created by PhpStorm.
 * User: Cyril
 * Date: 18/10/2015
 * Time: 13:32
 */

namespace AppBundle\DataFixtures;

use AppBundle\Document\Challenge;

class FixturesHelper
{
    public function __construct()
    {
        $this->faker = \Faker\Factory::create();
    }
}