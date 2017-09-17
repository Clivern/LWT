<?php

namespace AppBundle\Module\Service\Core;

use AppBundle\Module\Contract\Core\User as UserContract;
use Doctrine\ORM\EntityManager;
use AppBundle\Entity\User as UserEntity;

/**
 * User Service
 *
 * @package AppBundle\Module\Service\Core
 */
class User implements UserContract
{
    /**
     * @var EntityManager
     */
    protected $entityManager;

    /**
     * Service Constructor
     *
     * @param EntityManager $entityManager
     */
    public function __construct(EntityManager $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * Get by id
     *
     * @param  integer $id
     * @return mixed
     */
    public function getById($id)
    {
        $user = $this->entityManager->getRepository(UserEntity::class)->findOneBy(['id' => $id]);

        return (!empty($user)) ? $user : false;
    }

    /**
     * Get by username
     *
     * @param  string $username
     * @return mixed
     */
    public function getByUsername($username)
    {
        $user = $this->entityManager->getRepository(UserEntity::class)->findOneBy(['username' => $username]);

        return (!empty($user)) ? $user : false;
    }

    /**
     * Get by email
     *
     * @param  string $email
     * @return mixed
     */
    public function getByEmail($email)
    {
        $user = $this->entityManager->getRepository(UserEntity::class)->findOneBy(['email' => $email]);

        return (!empty($user)) ? $user : false;
    }

    /**
     * Get by api token
     *
     * @param  string $apiToken
     * @return mixed
     */
    public function getByApiToken($apiToken)
    {
        $user = $this->entityManager->getRepository(UserEntity::class)->findOneBy(['apiToken' => $apiToken]);

        return (!empty($user)) ? $user : false;
    }

    /**
     * Check if username exist
     *
     * @param  string $username
     * @return mixed
     */
    public function chechUsername($username, $userId)
    {
        $user = $this->entityManager->getRepository(UserEntity::class)->findOneBy(['username' => $username]);

        return (!empty($user) && ($user->getId() != $userId)) ? true : false;
    }

    /**
     * Check if email exist
     *
     * @param  string $email
     * @return mixed
     */
    public function checkEmail($email, $userId)
    {
        $user = $this->entityManager->getRepository(UserEntity::class)->findOneBy(['email' => $email]);

        return (!empty($user) && ($user->getId() != $userId)) ? true : false;
    }

    /**
     * Check if api token exist
     *
     * @param  string $apiToken
     * @return mixed
     */
    public function checkApiToken($apiToken)
    {
        $user = $this->entityManager->getRepository(UserEntity::class)->findOneBy(['apiToken' => $apiToken]);

        return (!empty($user)) ? true : false;
    }

    /**
     * Update user by id
     *
     * @param  integer $id
     * @param  array $newData
     * @return boolean
     */
    public function updateById($id, $newData)
    {
        $user = $this->getById($id);

        if( !empty($user) && !empty($newData) ){
            if( isset($newData['name']) ){
                $user->setName($newData['name']);
            }
            if( isset($newData['username']) ){
                $user->setUsername($newData['username']);
            }
            if( isset($newData['email']) ){
                $user->setEmail($newData['email']);
            }
            $user->setUpdatedAt(new \DateTime());
            $this->entityManager->flush();

            return true;
        }

        return false;
    }

    /**
     * Update access token if expiry time reached
     *
     * @param  integer $id
     * @return boolean
     */
    public function updateAccessTokenById($id)
    {
        $user = $this->getById($id);

        if( !empty($user) ){
            if( (time() + 60 * 60) > $user->getApiTokenExpire() ){

                $new_token = password_hash(substr(md5(rand()), 0, 20), PASSWORD_DEFAULT);
                $token_expire = time() + (24 * 60 * 60);

                while ( $this->checkApiToken($new_token) ) {
                    $new_token = password_hash(substr(md5(rand()), 0, 20), PASSWORD_DEFAULT);
                }

                $user->setApiToken($new_token);
                $user->setApiTokenExpire($token_expire);
                $user->setUpdatedAt(new \DateTime());
                $this->entityManager->flush();
                return true;
            }
            return true;
        }

        return false;
    }
}