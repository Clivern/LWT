<?php

namespace Tests\AppBundle\Controller\API\V1;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use AppBundle\Entity\User as UserEntity;
use AppBundle\Entity\Server as ServerEntity;

/**
 * Server API Test Cases
 *
 * @package Tests\AppBundle\Controller\API\V1
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
        $server = $this->entityManager->getRepository(ServerEntity::class)->findOneBy(['assetId' => '123']);

        if( $server ){
            $this->entityManager->remove($server);
            $this->entityManager->flush();
        }

        $user = $this->entityManager->getRepository(UserEntity::class)->findOneBy(['username' => 'clivern']);

        $client = static::createClient();
        $client->request(
            'POST',
            '/api/v1/server?api_token=' . $user->getApiToken(),
            ['name'=>'R234', 'brand'=>'Dell', 'asset_id'=>'123', 'price'=>'200.35']
        );

        $this->assertContains('"success":true', $client->getResponse()->getContent());
    }

    /**
     * Test Get Server
     *
     * @return void
     */
    public function testGetServer()
    {
        $server = $this->entityManager->getRepository(ServerEntity::class)->findOneBy(['assetId' => '123']);

        $user = $this->entityManager->getRepository(UserEntity::class)->findOneBy(['username' => 'clivern']);

        $client = static::createClient();
        $client->request(
            'GET',
            '/api/v1/server/' . $server->getId() . '?api_token=' . $user->getApiToken()
        );

        $this->assertContains('"success":true', $client->getResponse()->getContent());
        $this->assertContains('R234', $client->getResponse()->getContent());
    }

    /**
     * Test Get Servers
     *
     * @return void
     */
    public function testGetServers()
    {
        $user = $this->entityManager->getRepository(UserEntity::class)->findOneBy(['username' => 'clivern']);

        $client = static::createClient();
        $client->request(
            'GET',
            '/api/v1/server' . '?api_token=' . $user->getApiToken()
        );

        $this->assertContains('"success":true', $client->getResponse()->getContent());
        $this->assertContains('R234', $client->getResponse()->getContent());
    }

    /**
     * Test Delete Server
     *
     * @return void
     */
    public function testDeleteServer()
    {
        $server = $this->entityManager->getRepository(ServerEntity::class)->findOneBy(['assetId' => '123']);
        $user = $this->entityManager->getRepository(UserEntity::class)->findOneBy(['username' => 'clivern']);

        $client = static::createClient();
        $client->request(
            'DELETE',
            '/api/v1/server/' . $server->getId() . '?api_token=' . $user->getApiToken()
        );

        $this->assertContains('"success":true', $client->getResponse()->getContent());
    }
}