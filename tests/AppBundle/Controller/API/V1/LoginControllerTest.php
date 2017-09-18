<?php

namespace Tests\AppBundle\Controller\API\V1;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

/**
 * Login API Test Cases
 *
 * @package Tests\AppBundle\Controller\API\V1
 */
class LoginControllerTest extends WebTestCase
{

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
}