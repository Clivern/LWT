<?php

namespace Tests\AppBundle\Module\Service\Core;

use AppBundle\Module\Service\Core\User as UserService;
use AppBundle\Module\Service\Core\Server as ServerService;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

/**
 * Server Service Test
 *
 * @package Tests\AppBundle\Module\Service\Core
 */
class ServerTest extends KernelTestCase
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
    }

    /**
     * Test Insert
     *
     * @return void
     */
    public function testInsert()
    {
        $this->server->deleteByAssetId('87523');
        $this->server->deleteByAssetId('87864');

        $user = $this->user->getByUsername('lwt');

        $this->assertTrue((boolean) $this->server->insert([
            'asset_id' => '87523',
            'user' => $user,
            'name' => 'K123',
            'brand' => 'Dell',
            'price' => '300.03',
        ]));
        $this->assertTrue((boolean) $this->server->insert([
            'asset_id' => '87864',
            'user' => $user,
            'name' => 'K183',
            'brand' => 'HP',
            'price' => '890',
        ]));
    }


    /**
     * Test Get By Asset Id
     *
     * @return void
     */
    public function testGetByAssetId()
    {
        $user = $this->user->getByUsername('lwt');
        $server = $this->server->getByAssetId('87523');
        $this->assertEquals('K123', $server->getName());
    }

    /**
     * Test Get By Id
     *
     * @return void
     */
    public function testGetById()
    {
        $user = $this->user->getByUsername('lwt');
        $server = $this->server->getByAssetId('87523');
        $server = $this->server->getById($server->getId());
        $this->assertEquals('K123', $server->getName());
    }

    /**
     * Test Check Asset Id
     *
     * @return void
     */
    public function testCheckAssetId()
    {
        $this->assertTrue($this->server->checkAssetId('87523'));
    }

    /**
     * Test Update By Id
     *
     * @return void
     */
    public function testUpdateById()
    {
        $server = $this->server->getByAssetId('87523');
        $this->assertTrue($this->server->updateById($server->getId(), [
            'name' => 'P273',
            'brand' => 'Apple'
        ]));
    }

    /**
     * Test Update By Asset Id
     *
     * @return void
     */
    public function testUpdateByAssetId()
    {
        $this->assertTrue($this->server->updateByAssetId('87864', [
            'name' => 'O2662',
            'brand' => 'Samsung'
        ]));
    }

    /**
     * Test User Owns
     *
     * @return void
     */
    public function testUserOwns()
    {
        $server = $this->server->getByAssetId('87523');
        $user = $this->user->getByUsername('lwt');
        $this->assertTrue($this->server->userOwns($user->getId(), $server->getId()));
    }

    /**
     * Test Delete By Id
     *
     * @return void
     */
    public function testDeleteById()
    {
        $server = $this->server->getByAssetId('87523');
        $this->assertTrue($this->server->deleteById($server->getId()));
    }

    /**
     * Test Delete By Asset Id
     *
     * @return void
     */
    public function testDeleteByAssetId()
    {
        $this->assertTrue($this->server->deleteByAssetId('87864'));
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