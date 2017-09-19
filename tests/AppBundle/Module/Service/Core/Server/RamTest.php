<?php

namespace Tests\AppBundle\Module\Service\Core\Server;

use AppBundle\Module\Service\Core\User as UserService;
use AppBundle\Module\Service\Core\Server as ServerService;
use AppBundle\Module\Service\Core\Server\Ram as RamService;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

/**
 * Ram Service Test
 *
 * @package Tests\AppBundle\Module\Service\Core\Server
 */
class RamTest extends KernelTestCase
{
    /**
     * @var \Doctrine\ORM\EntityManager
     */
    protected $entityManager;

    /**
     * @var UserService
     */
    protected $user;

    /**
     * @var ServerService
     */
    protected $server;

    /**
     * @var RamService
     */
    protected $ram;

    /**
     * {@inheritDoc}
     */
    protected function setUp()
    {
        self::bootKernel();

        $this->entityManager = static::$kernel->getContainer()
            ->get('doctrine')
            ->getManager();

        $this->user = new UserService($this->entityManager);
        $this->server = new ServerService($this->entityManager);
        $this->ram = new RamService($this->entityManager);
    }

    /**
     * Test Insert
     *
     * @return void
     */
    public function testInsert()
    {
        $user = $this->user->getByUsername('lwt');

        $this->assertTrue($this->server->insert([
            'asset_id' => '78453',
            'user' => $user,
            'name' => 'K123',
            'brand' => 'Dell',
            'price' => '300.03',
        ]));

        $server = $this->server->getByAssetId('78453');

        $this->assertTrue($this->ram->insert([
            'server' => $server,
            'user' => $user,
            'type' => 'DDR3',
            'size' => '3'
        ]));
    }

    /**
     * Test Get By Server Id
     *
     * @return void
     */
    public function testGetByServerId()
    {
        $server = $this->server->getByAssetId('78453');
        $rams = $this->ram->getByServerId($server->getId(), 1, 100, true);
        $this->assertEquals($rams[0]['type'], 'DDR3');
    }

    /**
     * Test User Owns
     *
     * @return void
     */
    public function testUserOwns()
    {
        $user = $this->user->getByUsername('lwt');
        $server = $this->server->getByAssetId('78453');
        $rams = $this->ram->getByServerId($server->getId(), 1, 100, true);
        $this->assertTrue($this->ram->userOwns($user->getId(), $rams[0]['id']));
    }

    /**
     * Test Get By Id
     *
     * @return void
     */
    public function testGetById()
    {
        $server = $this->server->getByAssetId('78453');
        $rams = $this->ram->getByServerId($server->getId(), 1, 100, true);
        $ram = $this->ram->getById($rams[0]['id']);
        $this->assertEquals('DDR3', $ram->getType());
    }

    /**
     * Test Update By Id
     *
     * @return void
     */
    public function testUpdateById()
    {
        $server = $this->server->getByAssetId('78453');
        $rams = $this->ram->getByServerId($server->getId(), 1, 100, true);
        $this->assertTrue($this->ram->updateById($rams[0]['id'], ['size' => '6']));
    }

    /**
     * Test Delete By Id
     *
     * @return void
     */
    public function testDeleteById()
    {
        $server = $this->server->getByAssetId('78453');
        $rams = $this->ram->getByServerId($server->getId(), 1, 100, true);
        $this->assertTrue($this->ram->deleteById($rams[0]['id']));
        $this->assertTrue($this->server->deleteByAssetId('78453'));
    }

    /**
     * {@inheritDoc}
     */
    protected function tearDown()
    {
        parent::tearDown();
        $this->entityManager->close();
        $this->entityManager = null; // avoid memory leaks
    }
}