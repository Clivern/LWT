<?php

namespace Tests\AppBundle\Controller\API\V1;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use AppBundle\Entity\User as UserEntity;

/**
 * User API Test Cases
 *
 * @package Tests\AppBundle\Controller\API\V1
 */
class UserControllerTest extends WebTestCase
{

    /**
     * @var UserEntity
     */
    protected $user;

    /**
     * Class Constructor
     */
    public function __construct()
    {
        $client = static::createClient();
        $em = $client->getContainer()->get('doctrine.orm.entity_manager');
        $this->user = $em->getRepository(UserEntity::class)->findOneBy(['username' => 'clivern']);
    }

    /**
     * Test User Update API Success
     *
     * @return void
     */
    public function testUpdateSuccess()
    {
        $client = static::createClient();
        $client->request(
            'PUT',
            '/api/user/' . $this->user->getId() . '?api_token=$2y$10$7263UTiI9ExW1HL05QnOLefmRHJtYXoOjh.LFRqUmZ3pI2Q5O99MS',
            ['name' => 'Clivern', 'username' => 'clivern', 'email' => 'hello@clivern.com']
        );
        $this->assertContains('"success":true', $client->getResponse()->getContent());
    }

    /**
     * Test User Update API Failure
     *
     * @return void
     */
    public function testUpdateFailure()
    {
        $client = static::createClient();
        $client->request(
            'PUT',
            '/api/user/' . $this->user->getId() . '?api_token=$2y$10$7263UTiI9ExW1HL05QnOLefmRHJtYXoOjh.LFRqUmZ3pI2Q5O99MS',
            ['name' => ' ', 'username' => 'clivern', 'email' => 'hello@clivern.com']
        );
        $this->assertContains('"success":false', $client->getResponse()->getContent());
    }
}