<?php

namespace AppBundle\Module\Contract\Core\Server;

/**
 * Ram Service Contract
 *
 * @package AppBundle\Module\Contract\Core\Server
 */
interface Ram
{

    /**
     * Check if user owns this ram
     *
     * @param  integer $userId
     * @param  integer $ramId
     * @return boolean
     */
    public function userOwns($userId, $ramId);

    /**
     * Get rams by server id
     *
     * @param  integer  $serverId
     * @param  integer $currentPage
     * @param  integer $perPage
     * @param  boolean $asArray
     * @return array
     */
    public function getByServerId($serverId, $currentPage = 1, $perPage = 10, $asArray = false);

    /**
     * Get by id
     *
     * @param  integer $id
     * @return mixed
     */
    public function getById($id);

    /**
     * Insert Data
     *
     * @param array $data
     * @return boolean
     */
    public function insert($data);

    /**
     * Update by id
     *
     * @param  integer $id
     * @param  array $newData
     * @return boolean
     */
    public function updateById($id, $newData);

    /**
     * Delete by id
     *
     * @param integer $id
     * @return boolean
     */
    public function deleteById($id);
}