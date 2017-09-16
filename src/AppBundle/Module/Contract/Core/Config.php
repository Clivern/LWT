<?php

namespace AppBundle\Module\Contract\Core;

/**
 * Config Service Contract
 *
 * @package AppBundle\Module\Contract\Core
 */
interface Config
{

    /**
     * Insert a new config
     *
     * @param  string $key
     * @param  mixed $value
     * @param  string $autoload
     * @return boolean
     */
    public function insert($key, $value, $autoload = 'off');

    /**
     * Autoload configs
     *
     * @param  string $type
     * @return boolean
     */
    public function autoload($type = 'on');

    /**
     * Get config by key
     *
     * @param  string  $key
     * @param  boolean $default
     * @return mixed
     */
    public function getByKey($key, $default = false);

    /**
     * Update config by key
     *
     * @param  string  $key
     * @param  mixed $value
     * @return boolean
     */
    public function updateByKey($key, $value);

    /**
     * Update config by id
     *
     * @param  integer  $id
     * @param  mixed $value
     * @return boolean
     */
    public function updateById($id, $value);

    /**
     * Update Refersh Token if Expired
     *
     * @return boolean
     */
    public function updateRefreshToken();

    /**
     * Delete config by id
     *
     * @param  integer $id
     * @return boolean
     */
    public function deleteById($id);

    /**
     * Delete config by key
     *
     * @param  string $key
     * @return boolean
     */
    public function deleteByKey($key);
}