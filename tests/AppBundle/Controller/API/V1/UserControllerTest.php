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
    protected $entityManager;

    /**
     * Class Constructor
     */
    public function __construct()
    {
        $client = static::createClient();
        $this->entityManager = $client->getContainer()->get('doctrine.orm.entity_manager');
    }

    /**
     * Test User Update API Success
     *
     * @return void
     */
    public function testUpdateSuccess()
    {
        $user = $this->entityManager->getRepository(UserEntity::class)->findOneBy(['username' => 'clivern']);

        $client = static::createClient();
        $client->request(
            'PUT',
            '/api/user/' . $user->getId() . '?api_token=' . $user->getApiToken(),
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
        $user = $this->entityManager->getRepository(UserEntity::class)->findOneBy(['username' => 'clivern']);

        $client = static::createClient();
        $client->request(
            'PUT',
            '/api/user/' . $user->getId() . '?api_token=' . $user->getApiToken(),
            ['name' => ' ', 'username' => 'clivern', 'email' => 'hello@clivern.com']
        );
        $this->assertContains('"success":false', $client->getResponse()->getContent());
    }
}