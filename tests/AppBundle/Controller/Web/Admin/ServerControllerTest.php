<?php

namespace Tests\AppBundle\Controller\Web\Admin;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;
use Symfony\Component\BrowserKit\Cookie;
use AppBundle\Entity\User as UserEntity;
use AppBundle\Entity\Server as ServerEntity;

/**
 * Server Controller Test
 *
 * @package Tests\AppBundle\Controller\Web\Admin
 */
class ServerControllerTest extends WebTestCase
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
     * Test Create Server
     *
     * @return void
     */
    public function testCreateServer()
    {
        $server = $this->entityManager->getRepository(ServerEntity::class)->findOneBy(['assetId' => '623528']);

        if( $server ){
            $this->entityManager->remove($server);
            $this->entityManager->flush();
        }

        $user = $this->entityManager->getRepository(UserEntity::class)->findOneBy(['username' => 'clivern']);

        $client = static::createClient();
        $client->request(
            'POST',
            '/api/v1/server?api_token=' . $user->getApiToken(),
            ['name'=>'R234', 'brand'=>'Dell', 'asset_id'=>'623528', 'price'=>'200.35']
        );
        $this->assertContains('"success":true', $client->getResponse()->getContent());
    }

    /**
     * Test List Page
     *
     * @return void
     */
    public function testUnAuthenticatedList()
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
    public function testUnAuthenticatedAdd()
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
    public function testUnAuthenticatedView()
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/admin/servers/1/view');
        $this->assertEquals(302, $client->getResponse()->getStatusCode());
    }

    /**
     * Test Authenticated Access
     *
     * @return void
     */
    public function testAuthenticatedList()
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

    /**
     * Test Authenticated Access
     *
     * @return void
     */
    public function testAuthenticatedAdd()
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
        $crawler = $client->request('GET', '/admin/servers/add');
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
    }

    /**
     * Test Authenticated Access
     *
     * @return void
     */
    public function testAuthenticatedView()
    {
        $server = $this->entityManager->getRepository(ServerEntity::class)->findOneBy(['assetId' => '623528']);

        $client = static::createClient();
        $session = $client->getContainer()->get('session');
        $firewall = 'main';
        $user = $this->entityManager->getRepository(UserEntity::class)->findOneBy(['username' => 'clivern']);
        $token = new UsernamePasswordToken($user, null, $firewall, $user->getRoles());
        $session->set('_security_'.$firewall, serialize($token));
        $session->save();
        $cookie = new Cookie($session->getName(), $session->getId());
        $client->getCookieJar()->set($cookie);
        $crawler = $client->request('GET', '/admin/servers/' . $server->getId() .  '/view');
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
    }

    /**
     * Test Delete Server
     *
     * @return void
     */
    public function testDeleteServer()
    {
        $server = $this->entityManager->getRepository(ServerEntity::class)->findOneBy(['assetId' => '623528']);
        $user = $this->entityManager->getRepository(UserEntity::class)->findOneBy(['username' => 'clivern']);

        $client = static::createClient();
        $client->request(
            'DELETE',
            '/api/v1/server/' . $server->getId() . '?api_token=' . $user->getApiToken()
        );

        $this->assertContains('"success":true', $client->getResponse()->getContent());
    }
}