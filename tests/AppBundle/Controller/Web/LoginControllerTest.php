<?php

namespace Tests\AppBundle\Controller\Web;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

/**
 * Login Controller Test
 *
 * @package Tests\AppBundle\Controller\Web
 */
class LoginControllerTest extends WebTestCase
{

    /**
     * Test Login Page
     *
     * @return void
     */
    public function testIndex()
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/login');
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $this->assertContains('Login', $crawler->filter('div.divider')->text());
    }
}