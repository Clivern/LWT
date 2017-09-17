<?php

namespace AppBundle\Module\Contract\Core;

/**
 * User Service Contract
 *
 * @package AppBundle\Module\Contract\Core
 */
interface User
{

    /**
     * Get by id
     *
     * @param  integer $id
     * @return mixed
     */
    public function getById($id);

    /**
     * Get by username
     *
     * @param  string $username
     * @return mixed
     */
    public function getByUsername($username);

    /**
     * Get by email
     *
     * @param  string $email
     * @return mixed
     */
    public function getByEmail($email);

    /**
     * Get by api token
     *
     * @param  string $apiToken
     * @return mixed
     */
    public function getByApiToken($apiToken);

    /**
     * Check if username exist
     *
     * @param  string $username
     * @return mixed
     */
    public function chechUsername($username, $userId);

    /**
     * Check if email exist
     *
     * @param  string $email
     * @return mixed
     */
    public function checkEmail($email, $userId);

    /**
     * Check if api token exist
     *
     * @param  string $apiToken
     * @return mixed
     */
    public function checkApiToken($apiToken);

    /**
     * Update user by id
     *
     * @param  integer $id
     * @param  array $newData
     * @return boolean
     */
    public function updateById($id, $newData);

    /**
     * Update access token if expiry time reached
     *
     * @param  integer $id
     * @return boolean
     */
    public function updateAccessTokenById($id);
}