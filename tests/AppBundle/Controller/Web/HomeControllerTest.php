<?php

namespace Tests\AppBundle\Controller\Web;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

/**
 * Home Controller Test
 *
 * @package Tests\AppBundle\Controller\Web
 */
class HomeControllerTest extends WebTestCase
{
    public function testIndex()
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/');
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $this->assertContains('Know More', $crawler->filter('a.tiny')->text());
    }
}