<?php

namespace AppBundle\Module\Contract\Core;

/**
 * Auth Service Contract
 *
 * @package AppBundle\Module\Contract\Core
 */
interface Auth
{

    /**
     * Check Credentials
     *
     * @param  string $username
     * @param  string $password
     * @return boolean
     */
    public function checkCredentials($username, $password);

    /**
     * Login by username
     *
     * @param  string $username
     * @return boolean
     */
    public function loginByUsername($username);

    /**
     * Login by user id
     *
     * @param  integer $id
     * @return boolean
     */
    public function loginById($id);

    /**
     * Check if user is logged
     *
     * @return mixed
     */
    public function isLogged();
}