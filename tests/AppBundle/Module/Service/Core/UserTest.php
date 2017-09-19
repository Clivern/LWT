<?php

namespace Tests\AppBundle\Module\Service\Core;

use AppBundle\Module\Service\Core\User as UserService;
use Symfony\Bundle\FrameworkBundle\Test\KernelTestCase;

/**
 * User Service Test
 *
 * @package Tests\AppBundle\Module\Service\Core
 */
class UserTest extends KernelTestCase
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
     * {@inheritDoc}
     */
    protected function setUp()
    {
        self::bootKernel();

        $this->entityManager = static::$kernel->getContainer()
            ->get('doctrine')
            ->getManager();

        $this->user = new UserService($this->entityManager);
    }

    /**
     * Test Get By Id
     *
     * @return void
     */
    public function testGetById()
    {
        $user = $this->user->getByUsername('lwt');
        $user = $this->user->getById($user->getId());
        $this->assertEquals('hello@lwt.com', $user->getEmail());
    }

    /**
     * Test Get By Username
     *
     * @return void
     */
    public function testGetByUsername()
    {
        $user = $this->user->getByUsername('lwt');
        $this->assertEquals('hello@lwt.com', $user->getEmail());
    }

    /**
     * Test Get By Email
     *
     * @return void
     */
    public function testGetByEmail()
    {
        $user = $this->user->getByEmail('hello@lwt.com');
        $this->assertEquals('lwt', $user->getUsername());
    }

    /**
     * Test Get By API Token
     *
     * @return void
     */
    public function testGetByApiToken()
    {
        $user = $this->user->getByApiToken('$2y$10$7263UTiI9ExW1HL05QnOLefmRHJtYXoOjh.LFRqUmZ3pI2Q789K8L');
        $this->assertEquals('lwt', $user->getUsername());
    }

    /**
     * Test Check Username
     *
     * @return void
     */
    public function testCheckUsername()
    {
        $user = $this->user->getByUsername('lwt');
        $this->assertTrue($this->user->chechUsername('lwt', $user->getId() + 1));
    }

    /**
     * Test Check Email
     *
     * @return void
     */
    public function testCheckEmail()
    {
        $user = $this->user->getByUsername('lwt');
        $this->assertTrue($this->user->checkEmail('hello@lwt.com', $user->getId() + 1));
    }

    /**
     * Test Check API Token
     *
     * @return void
     */
    public function testCheckApiToken()
    {
        $this->assertTrue($this->user->checkApiToken('$2y$10$7263UTiI9ExW1HL05QnOLefmRHJtYXoOjh.LFRqUmZ3pI2Q789K8L'));
    }

    /**
     * Test Update By Id
     *
     * @return void
     */
    public function testUpdateById()
    {
        $user = $this->user->getByUsername('lwt');

        $this->assertTrue($this->user->updateById($user->getId(), ['email' => 'hello@lwt.com']));
        $this->assertFalse($this->user->updateById($user->getId(), []));
    }

    /**
     * Test Update Access Token
     *
     * @return void
     */
    public function testUpdateAccessTokenById()
    {
        $user = $this->user->getByUsername('lwt');
        $this->assertTrue($this->user->updateAccessTokenById($user->getId()));
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