<?php

namespace AppBundle\Module\Contract\Core;

/**
 * Server Service Contract
 *
 * @package AppBundle\Module\Contract\Core
 */
interface Server
{

    /**
     * Check if user owns this server
     *
     * @param  integer $userId
     * @param  integer $serverId
     * @return boolean
     */
    public function userOwns($userId, $serverId);

    /**
     * Get Servers by user id
     *
     * @param  integer  $userId
     * @param  integer $currentPage
     * @param  integer $perPage
     * @param  boolean $asArray
     * @return array
     */
    public function getByUserId($userId, $currentPage = 1, $perPage = 10, $asArray = false);

    /**
     * Get by id
     *
     * @param  integer $id
     * @return mixed
     */
    public function getById($id);

    /**
     * Get by asset id
     *
     * @param  integer $assetId
     * @return mixed
     */
    public function getByAssetId($assetId);

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
     * Update by asset id
     *
     * @param  integer $assetId
     * @param  array $newData
     * @return boolean
     */
    public function updateByAssetId($assetId, $newData);

    /**
     * Check if asset id exist
     *
     * @param integer $assetId
     * @return boolean
     */
    public function checkAssetId($assetId);

    /**
     * Delete by id
     *
     * @param integer $id
     * @return boolean
     */
    public function deleteById($id);

    /**
     * Delete by asset id
     *
     * @param integer $assetId
     * @return boolean
     */
    public function deleteByAssetId($assetId);
}