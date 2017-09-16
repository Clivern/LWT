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
     * @param  string $api_token
     * @return mixed
     */
    public function getByApiToken($api_token);

    /**
     * Check if username exist
     *
     * @param  string $username
     * @return mixed
     */
    public function chechUsername($username);

    /**
     * Check if email exist
     *
     * @param  string $email
     * @return mixed
     */
    public function checkEmail($email);

    /**
     * Update user by id
     *
     * @param  integer $id
     * @param  array $new_data
     * @return boolean
     */
    public function updateById($id, $new_data);

    /**
     * Update access token if expiry time reached
     *
     * @param  integer $id
     * @return boolean
     */
    public function updateAccessTokenById($id);
}