<?php

namespace AppBundle\Module\Service\Core;

use AppBundle\Module\Contract\Core\Server as ServerContract;
use Doctrine\ORM\EntityManagerInterface;
use AppBundle\Entity\Server as ServerEntity;

/**
 * Server Service
 *
 * @package AppBundle\Module\Service\Core
 */
class Server implements ServerContract
{
    /**
     * @var EntityManagerInterface
     */
    protected $entityManager;

    /**
     * Service Constructor
     *
     * @param EntityManagerInterface $entityManager
     */
    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    /**
     * Check if user owns this server
     *
     * @param  integer $userId
     * @param  integer $serverId
     * @return boolean
     */
    public function userOwns($userId, $serverId)
    {
        $server = $this->entityManager->getRepository(ServerEntity::class)->findOneBy(['userId' => $userId, 'id' => $serverId]);

        return (!empty($server)) ? true : false;
    }

    /**
     * Get Servers by user id
     *
     * @param  integer  $userId
     * @param  integer $currentPage
     * @param  integer $perPage
     * @param  boolean $asArray
     * @return array
     */
    public function getByUserId($userId, $currentPage = 1, $perPage = 10, $asArray = false)
    {
        $servers = $this->entityManager->getRepository(ServerEntity::class)->findBy(['userId' => $userId]);

        if( $asArray ){
            $servers_list = [];
            foreach ($servers as $server) {
                $servers_list[] = [
                    'id' => $server->getId(),
                    'asset_id' => $server->getAssetId(),
                    'name' => $server->getName(),
                    'brand' => $server->getBrand(),
                    'price' => $server->getPrice()
                ];
            }

            return $servers_list;
        }

        return $servers;
    }

    /**
     * Get by id
     *
     * @param  integer $id
     * @return mixed
     */
    public function getById($id)
    {
        $server = $this->entityManager->getRepository(ServerEntity::class)->findOneBy(['id' => $id]);

        return (!empty($server)) ? $server : false;
    }

    /**
     * Get by asset id
     *
     * @param  integer $assetId
     * @return mixed
     */
    public function getByAssetId($assetId)
    {
        $server = $this->entityManager->getRepository(ServerEntity::class)->findOneBy(['assetId' => $assetId]);

        return (!empty($server)) ? $server : false;
    }

    /**
     * Insert Data
     *
     * @param array $data
     * @return boolean
     */
    public function insert($data)
    {
        $server = new ServerEntity();
        $server->setAssetId($data['asset_id']);
        $server->setUser($data['user']);
        $server->setName($data['name']);
        $server->setBrand($data['brand']);
        $server->setPrice($data['price']);
        $this->entityManager->persist($server);

        $this->entityManager->flush();

        return true;
    }

    /**
     * Update by id
     *
     * @param  integer $id
     * @param  array $newData
     * @return boolean
     */
    public function updateById($id, $newData)
    {
        $server = $this->getById($id);

        if( !empty($server) && !empty($newData) ){
            if( isset($newData['asset_id']) ){
                $server->setAssetId($newData['asset_id']);
            }
            if( isset($newData['name']) ){
                $server->setName($newData['name']);
            }
            if( isset($newData['brand']) ){
                $server->setBrand($newData['brand']);
            }
            if( isset($newData['price']) ){
                $server->setPrice($newData['price']);
            }

            $this->entityManager->flush();

            return true;
        }

        return false;
    }

    /**
     * Update by asset id
     *
     * @param  integer $assetId
     * @param  array $newData
     * @return boolean
     */
    public function updateByAssetId($assetId, $newData)
    {
        $server = $this->getByAssetId($assetId);

        if( !empty($server) && !empty($newData) ){
            if( isset($newData['asset_id']) ){
                $server->setAssetId($newData['asset_id']);
            }
            if( isset($newData['name']) ){
                $server->setName($newData['name']);
            }
            if( isset($newData['brand']) ){
                $server->setBrand($newData['brand']);
            }
            if( isset($newData['price']) ){
                $server->setPrice($newData['price']);
            }

            $this->entityManager->flush();

            return true;
        }

        return false;
    }

    /**
     * Check if asset id exist
     *
     * @param integer $assetId
     * @return boolean
     */
    public function checkAssetId($assetId)
    {
        $server = $this->getByAssetId($assetId);

        return (!empty($server)) ? true : false;
    }

    /**
     * Delete by id
     *
     * @param integer $id
     * @return boolean
     */
    public function deleteById($id)
    {
        $server = $this->getById($id);

        if( !empty($server) ){
            $this->entityManager->remove($server);
            $this->entityManager->flush();

            return true;
        }

        return false;
    }

    /**
     * Delete by asset id
     *
     * @param integer $assetId
     * @return boolean
     */
    public function deleteByAssetId($assetId)
    {
        $server = $this->getByAssetId($assetId);

        if( !empty($server) ){
            $this->entityManager->remove($server);
            $this->entityManager->flush();

            return true;
        }

        return false;
    }
}