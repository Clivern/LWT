<?php

namespace Tests\AppBundle\Module\Service\Core;

use AppBundle\Module\Service\Core\Config as ConfigService;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

/**
 * Config Service Test
 *
 * @package Tests\AppBundle\Module\Service\Core
 */
class ConfigTest extends KernelTestCase
{
    /**
     * @var \Doctrine\ORM\EntityManager
     */
    protected $entityManager;

    /**
     * @var ConfigService
     */
    protected $config;

    /**
     * {@inheritDoc}
     */
    protected function setUp()
    {
        self::bootKernel();

        $this->entityManager = static::$kernel->getContainer()
            ->get('doctrine')
            ->getManager();

        $this->config = new ConfigService($this->entityManager);
    }

    /**
     * Test Insert
     *
     * @return void
     */
    public function testInsert()
    {
        $this->config->deleteByKey('__test_key');
        $this->config->deleteByKey('__test_key_02');
        $this->assertTrue((boolean) $this->config->insert('__test_key', 'Test Value', 'off'));
    }

    /**
     * Test Autoload
     *
     * @return void
     */
    public function testAutoload()
    {
        $this->assertTrue($this->config->autoload('on'));
    }

    /**
     * Test Get by key
     *
     * @return void
     */
    public function testGetByKey()
    {
        $this->assertEquals($this->config->getByKey('__test_key'), 'Test Value');
    }

    /**
     * Test Update by key
     *
     * @return void
     */
    public function testUpdateByKey()
    {
        $this->assertTrue($this->config->updateByKey('__test_key', 'New Test Value'));
        $this->assertEquals($this->config->getByKey('__test_key'), 'New Test Value');
    }

    /**
     * Test Update by id
     *
     * @return void
     */
    public function testUpdateById()
    {
        $config = $this->config->getEntityByKey('__test_key');

        $this->assertTrue($this->config->updateById($config->getId(), 'Test Value'));
        $this->assertTrue((boolean) $this->config->insert('__test_key_02', 'Test Value', 'off'));

        $config = $this->config->getEntityByKey('__test_key_02');
        $this->assertTrue($this->config->deleteById($config->getId()));
    }

    /**
     * Test Delete by key
     *
     * @return void
     */
    public function testDeleteByKey()
    {
        $this->assertTrue($this->config->deleteByKey('__test_key'));
    }

    /**
     * Test Update Refresh Token
     *
     * @return void
     */
    public function testUpdateRefreshToken()
    {
        $this->assertTrue($this->config->updateRefreshToken());
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