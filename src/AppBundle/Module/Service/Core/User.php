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
    protected $entity_manager;

    /**
     * Service Constructor
     *
     * @param EntityManager $entity_manager
     */
    public function __construct(EntityManager $entity_manager)
    {
        $this->entity_manager = $entity_manager;
    }

    /**
     * Get by id
     *
     * @param  integer $id
     * @return mixed
     */
    public function getById($id)
    {
        $user = $this->entity_manager->getRepository(UserEntity::class)->findOneBy(['id' => $id]);

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
        $user = $this->entity_manager->getRepository(UserEntity::class)->findOneBy(['username' => $username]);

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
        $user = $this->entity_manager->getRepository(UserEntity::class)->findOneBy(['email' => $email]);

        return (!empty($user)) ? $user : false;
    }

    /**
     * Get by api token
     *
     * @param  string $api_token
     * @return mixed
     */
    public function getByApiToken($api_token)
    {
        $user = $this->entity_manager->getRepository(UserEntity::class)->findOneBy(['apiToken' => $api_token]);

        return (!empty($user)) ? $user : false;
    }

    /**
     * Check if username exist
     *
     * @param  string $username
     * @return mixed
     */
    public function chechUsername($username)
    {
        $user = $this->entity_manager->getRepository(UserEntity::class)->findOneBy(['username' => $username]);

        return (!empty($user)) ? true : false;
    }

    /**
     * Check if email exist
     *
     * @param  string $email
     * @return mixed
     */
    public function checkEmail($email)
    {
        $user = $this->entity_manager->getRepository(UserEntity::class)->findOneBy(['email' => $email]);

        return (!empty($user)) ? true : false;
    }

    /**
     * Update user by id
     *
     * @param  integer $id
     * @param  array $new_data
     * @return boolean
     */
    public function updateById($id, $new_data)
    {
        $user = $this->getById($id);

        if( !empty($user) && !empty($new_data) ){
            if( isset($new_data['name']) ){
                $user->setName($new_data['name']);
            }
            if( isset($new_data['username']) ){
                $user->setUsername($new_data['username']);
            }
            if( isset($new_data['email']) ){
                $user->setEmail($new_data['email']);
            }
            $this->entity_manager->flush();

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

                $new_token = password_hash(substr(md5(rand()), 0, 20);
                $token_expire = time() + (24 * 60 * 60);

                while ( empty($this->entity_manager->getRepository(UserEntity::class)->findOneBy(['apiToken' => $new_token])) ) {
                    $new_token = password_hash(substr(md5(rand()), 0, 20);
                }

                $user->setApiToken($new_token);
                $user->setApiTokenExpire($token_expire);
                $this->entity_manager->flush();
                return true;
            }
            return true;
        }

        return false;
    }
}