<?php

namespace Tests\AppBundle\Controller\API\V1;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use AppBundle\Entity\User as UserEntity;
use AppBundle\Entity\Config as ConfigEntity;

/**
 * Login API Test Cases
 *
 * @package Tests\AppBundle\Controller\API\V1
 */
class LoginControllerTest extends WebTestCase
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
     * Test Auth Success
     *
     * @return void
     */
    public function testAuthSuccess()
    {
        $client = static::createClient();
        $client->request(
            'POST',
            '/api/v1/auth',
            ['username' => 'clivern', 'password' => 'clivern']
        );
        $this->assertContains('"success":true', $client->getResponse()->getContent());
    }

    /**
     * Test Auth Failure
     *
     * @return void
     */
    public function testAuthFailure()
    {
        $client = static::createClient();
        $client->request(
            'POST',
            '/api/v1/auth',
            ['username' => 'cli', 'password' => 'clivern']
        );
        $this->assertContains('"success":false', $client->getResponse()->getContent());
    }

    /**
     * Test Get Access Token
     *
     * @return void
     */
    public function testGetAccessTocken()
    {
        $user = $this->entityManager->getRepository(UserEntity::class)->findOneBy(['username' => 'clivern']);
        $config = $this->entityManager->getRepository(ConfigEntity::class)->findOneBy(['configKey' => '_api_refresh_token']);

        $client = static::createClient();
        $client->request(
            'POST',
            '/api/v1/api_token' . '?api_token=' . $user->getApiToken(),
            ['refresh_token' => $config->getConfigValue()]
        );
        $this->assertContains('"success":true', $client->getResponse()->getContent());
    }

    /**
     * Test Get Refresh Token
     *
     * @return void
     */
    public function testGetRefreshTocken()
    {
        $user = $this->entityManager->getRepository(UserEntity::class)->findOneBy(['username' => 'clivern']);
        $config = $this->entityManager->getRepository(ConfigEntity::class)->findOneBy(['configKey' => '_api_refresh_token']);

        $client = static::createClient();
        $client->request(
            'GET',
            '/api/v1/refresh_token' . '?api_token=' . $user->getApiToken()
        );
        $this->assertContains('"success":true', $client->getResponse()->getContent());
    }
}