<?php

namespace Tests\AppBundle\Controller\Web\Admin;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

/**
 * Profile Controller Test
 *
 * @package Tests\AppBundle\Controller\Web\Admin
 */
class ProfileControllerTest extends WebTestCase
{

    /**
     * Test Profile Page
     *
     * @return void
     */
    public function testIndex()
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/admin/profile');
        $this->assertEquals(302, $client->getResponse()->getStatusCode());
    }
}