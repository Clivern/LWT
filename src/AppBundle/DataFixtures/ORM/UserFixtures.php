<?php

namespace AppBundle\DataFixtures\ORM;

use AppBundle\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

/**
 * Defines the sample users to load in the database before running the unit and
 * functional tests. Execute this command to load the data.
 *
 *   $ php bin/console doctrine:fixtures:load
 *
 * @package AppBundle\DataFixtures\ORM
 */
class UserFixtures extends Fixture
{

    /**
     * {@inheritdoc}
     */
    public function load(ObjectManager $manager)
    {
        $passwordEncoder = $this->container->get('security.password_encoder');

        $admin = new User();
        $admin->setName('Clivern');
        $admin->setUsername('clivern');
        $admin->setEmail('hello@clivern.com');
        $admin->setStatus('active');
        $admin->setApiToken('$2y$10$7263UTiI9ExW1HL05QnOLefmRHJtYXoOjh.LFRqUmZ3pI2Q5O99MS');
        $admin->setApiTokenExpire(time() + (60 * 24 * 60 * 60));
        $admin->setRememberToken('');
        $encoder = $this->container->get('security.password_encoder');
        $password = $encoder->encodePassword($admin, 'clivern');
        $admin->setPassword($password);
        $manager->persist($admin);
        $manager->flush();

        $admin = new User();
        $admin->setName('Lwt');
        $admin->setUsername('lwt');
        $admin->setEmail('hello@lwt.com');
        $admin->setStatus('active');
        $admin->setApiToken('$2y$10$7263UTiI9ExW1HL05QnOLefmRHJtYXoOjh.LFRqUmZ3pI2Q789K8L');
        $admin->setApiTokenExpire(time() + (60 * 24 * 60 * 60));
        $admin->setRememberToken('');
        $encoder = $this->container->get('security.password_encoder');
        $password = $encoder->encodePassword($admin, 'lwt');
        $admin->setPassword($password);
        $manager->persist($admin);
        $manager->flush();
    }
}