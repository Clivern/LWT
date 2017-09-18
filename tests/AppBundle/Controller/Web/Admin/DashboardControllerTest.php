<?php

namespace Tests\AppBundle\Controller\Web\Admin;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

/**
 * Dashboard Controller Test
 *
 * @package Tests\AppBundle\Controller\Web\Admin
 */
class DashboardControllerTest extends WebTestCase
{

    /**
     * Test Dashboard Page
     *
     * @return void
     */
    public function testIndex()
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/admin/dashboard');
        $this->assertEquals(302, $client->getResponse()->getStatusCode());
    }
}