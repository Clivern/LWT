<?php

namespace AppBundle\Module\Service\Core;

use AppBundle\Module\Contract\Core\Auth as AuthContract;
use Doctrine\ORM\EntityManager;
use AppBundle\Entity\User as UserEntity;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorage;
use Symfony\Component\Security\Core\Encoder\EncoderFactory;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;

/**
 * Auth Service
 *
 * @package AppBundle\Module\Service\Core
 */
class Auth implements AuthContract
{

    /**
     * @var EntityManager
     */
    protected $entityManager;

    /**
     * @var EncoderFactory
     */
    protected $encoderFactory;

    /**
     * @var TokenStorage
     */
    protected $tokenStorage;

    /**
     * ManualPasswordValidator constructor.
     *
     * @param EntityManager $entityManager
     * @param TokenStorage $tokenStorage
     * @param EncoderFactory $encoderFactory
     */
    public function __construct(EntityManager $entityManager, TokenStorage $tokenStorage, EncoderFactory $encoderFactory)
    {
        $this->entityManager = $entityManager;
        $this->encoderFactory = $encoderFactory;
        $this->tokenStorage = $tokenStorage;
    }

    /**
     * Check Credentials
     *
     * @param  string $username
     * @param  string $password
     * @return boolean
     */
    public function checkCredentials($username, $password)
    {
        $user = $this->getUserByUsername($username);

        if( empty($user) ){
            return false;
        }

        $encoder = $this->encoderFactory->getEncoder($user);

        if ($encoder->isPasswordValid($user->getPassword(), $password, $user->getSalt())) {
            return true;
        }

        return false;
    }

    /**
     * Login by username
     *
     * @param  string $username
     * @return boolean
     */
    public function loginByUsername($username)
    {
        $user = $this->getUserByUsername($username);

        if( empty($user) ){
            return false;
        }
        $token = new UsernamePasswordToken($user, null, "main", $user->getRoles());
        $this->tokenStorage->setToken($token);

        return true;
    }

    /**
     * Login by user id
     *
     * @param  integer $id
     * @return boolean
     */
    public function loginById($id)
    {
        $user = $this->getUserById($id);

        if( empty($user) ){
            return false;
        }
        $token = new UsernamePasswordToken($user, null, "main", $user->getRoles());
        $this->tokenStorage->setToken($token);

        return true;
    }

    /**
     * Get use by username
     *
     * @param string $username
     * @return mixed
     */
    protected function getUserByUsername($username)
    {
        $user = $this->entityManager->getRepository(UserEntity::class)->findOneBy(['username' => $username]);

        return (!empty($user)) ? $user : false;
    }

    /**
     * Get use by id
     *
     * @param integer $id
     * @return mixed
     */
    protected function getUserById($id)
    {
        $user = $this->entityManager->getRepository(UserEntity::class)->findOneBy(['id' => $id]);

        return (!empty($user)) ? $user : false;
    }
}