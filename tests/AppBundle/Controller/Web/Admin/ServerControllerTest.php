<?php

namespace Tests\AppBundle\Controller\Web\Admin;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

/**
 * Server Controller Test
 *
 * @package Tests\AppBundle\Controller\Web\Admin
 */
class ServerControllerTest extends WebTestCase
{

    /**
     * Test List Page
     *
     * @return void
     */
    public function testList()
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/admin/servers');
        $this->assertEquals(302, $client->getResponse()->getStatusCode());
    }

    /**
     * Test Add Page
     *
     * @return void
     */
    public function testAdd()
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/admin/servers/add');
        $this->assertEquals(302, $client->getResponse()->getStatusCode());
    }

    /**
     * Test View Page
     *
     * @return void
     */
    public function testView()
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/admin/servers/1/view');
        $this->assertEquals(302, $client->getResponse()->getStatusCode());
    }

}