<?php

namespace Tests\AppBundle\Controller\API\V1\Server;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use AppBundle\Entity\User as UserEntity;
use AppBundle\Entity\Server as ServerEntity;
use AppBundle\Entity\ServerRam as ServerRamEntity;

/**
 * Ram API Test Cases
 *
 * @package Tests\AppBundle\Controller\API\V1\Server
 */
class RamControllerTest extends WebTestCase
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
     * Test Create Ram
     *
     * @return void
     */
    public function testCreateServerRam()
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

        $server = $this->entityManager->getRepository(ServerEntity::class)->findOneBy(['assetId' => '123']);

        $client = static::createClient();
        $client->request(
            'POST',
            '/api/v1/server/' . $server->getId() . '/ram?api_token=' . $user->getApiToken(),
            ['type' => 'DDR3', 'size'=>'2']
        );

        $this->assertContains('"success":true', $client->getResponse()->getContent());
    }

    /**
     * Test Get Ram
     *
     * @return void
     */
    public function testGetServerRam()
    {
        $server = $this->entityManager->getRepository(ServerEntity::class)->findOneBy(['assetId' => '123']);
        $ram = $this->entityManager->getRepository(ServerRamEntity::class)->findOneBy(['type' => 'DDR3']);
        $user = $this->entityManager->getRepository(UserEntity::class)->findOneBy(['username' => 'clivern']);

        $client = static::createClient();
        $client->request(
            'GET',
            'api/v1/server/' . $server->getId() . '/ram/' . $ram->getId() . '?api_token=' . $user->getApiToken()
        );

        $this->assertContains('"success":true', $client->getResponse()->getContent());
        $this->assertContains('DDR3', $client->getResponse()->getContent());
    }

    /**
     * Test Get Rams
     *
     * @return void
     */
    public function testGetServerRams()
    {
        $server = $this->entityManager->getRepository(ServerEntity::class)->findOneBy(['assetId' => '123']);
        $user = $this->entityManager->getRepository(UserEntity::class)->findOneBy(['username' => 'clivern']);

        $client = static::createClient();
        $client->request(
            'GET',
            '/api/v1/server/' . $server->getId() . '/ram' . '?api_token=' . $user->getApiToken()
        );

        $this->assertContains('"success":true', $client->getResponse()->getContent());
        $this->assertContains('DDR3', $client->getResponse()->getContent());
    }

    /**
     * Test Delete Ram
     *
     * @return void
     */
    public function testDeleteServerRam()
    {
        $server = $this->entityManager->getRepository(ServerEntity::class)->findOneBy(['assetId' => '123']);
        $ram = $this->entityManager->getRepository(ServerRamEntity::class)->findOneBy(['type' => 'DDR3']);
        $user = $this->entityManager->getRepository(UserEntity::class)->findOneBy(['username' => 'clivern']);

        $client = static::createClient();
        $client->request(
            'DELETE',
            'api/v1/server/' . $server->getId() . '/ram/' . $ram->getId() . '?api_token=' . $user->getApiToken()
        );

        $this->assertContains('"success":true', $client->getResponse()->getContent());
    }
}