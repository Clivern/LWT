<?php

namespace AppBundle\DataFixtures\ORM;

use AppBundle\Entity\Config;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

/**
 * Defines the sample configs to load in the database before running the unit and
 * functional tests. Execute this command to load the data.
 *
 *   $ php bin/console doctrine:fixtures:load
 *
 * @package AppBundle\DataFixtures\ORM
 */
class ConfigFixtures extends Fixture
{

    /**
     * {@inheritdoc}
     */
    public function load(ObjectManager $manager)
    {
        $config1 = new Config();
        $config1->setConfigKey('_site_title');
        $config1->setConfigValue('LWT');
        $config1->setAutoload('on');
        $manager->persist($config1);


        $config2 = new Config();
        $config2->setConfigKey('_site_description');
        $config2->setConfigValue('Simple ERP Application In Symfony.');
        $config2->setAutoload('on');
        $manager->persist($config2);

        $manager->flush();
    }
}