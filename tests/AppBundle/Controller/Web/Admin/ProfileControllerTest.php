<?php

namespace Tests\AppBundle\Controller\Web\Admin;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;
use Symfony\Component\BrowserKit\Cookie;
use AppBundle\Entity\User as UserEntity;

/**
 * Profile Controller Test
 *
 * @package Tests\AppBundle\Controller\Web\Admin
 */
class ProfileControllerTest extends WebTestCase
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
     * Test Unauthenticated Access
     *
     * @return void
     */
    public function testUnAuthenticated()
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/admin/profile');
        $this->assertEquals(302, $client->getResponse()->getStatusCode());
    }

    /**
     * Test Authenticated Access
     *
     * @return void
     */
    public function testAuthenticated()
    {
        $client = static::createClient();
        $session = $client->getContainer()->get('session');
        $firewall = 'main';
        $user = $this->entityManager->getRepository(UserEntity::class)->findOneBy(['username' => 'clivern']);
        $token = new UsernamePasswordToken($user, null, $firewall, $user->getRoles());
        $session->set('_security_'.$firewall, serialize($token));
        $session->save();
        $cookie = new Cookie($session->getName(), $session->getId());
        $client->getCookieJar()->set($cookie);
        $crawler = $client->request('GET', '/admin/profile');
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
    }
}