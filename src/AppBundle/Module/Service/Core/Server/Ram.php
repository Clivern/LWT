<?php

namespace AppBundle\Module\Service\Core\Server;

use AppBundle\Module\Contract\Core\Server\Ram as RamContract;
use Doctrine\ORM\EntityManagerInterface;
use AppBundle\Entity\ServerRam as ServerRamEntity;

/**
 * Ram Service
 *
 * @package AppBundle\Module\Service\Core\Server
 */
class Ram implements RamContract
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
     * Check if user owns this ram
     *
     * @param  integer $userId
     * @param  integer $ramId
     * @return boolean
     */
    public function userOwns($userId, $ramId)
    {
        $ram = $this->entityManager->getRepository(ServerRamEntity::class)->findOneBy(['userId' => $userId, 'id' => $ramId]);

        return (!empty($ram)) ? true : false;
    }

    /**
     * Get rams by server id
     *
     * @param  integer  $serverId
     * @param  integer $currentPage
     * @param  integer $perPage
     * @param  boolean $asArray
     * @return array
     */
    public function getByServerId($serverId, $currentPage = 1, $perPage = 10, $asArray = false)
    {
        $rams = $this->entityManager->getRepository(ServerRamEntity::class)->findBy(['serverId' => $serverId]);

        if( $asArray ){
            $rams_list = [];
            foreach ($rams as $ram) {
                $rams_list[] = [
                    'id' => $ram->getId(),
                    'type' => $ram->getType(),
                    'size' => $ram->getSize()
                ];
            }

            return $rams_list;
        }

        return $rams;
    }

    /**
     * Get by id
     *
     * @param  integer $id
     * @return mixed
     */
    public function getById($id)
    {
        $ram = $this->entityManager->getRepository(ServerRamEntity::class)->findOneBy(['id' => $id]);

        return (!empty($ram)) ? $ram : false;
    }

    /**
     * Insert Data
     *
     * @param array $data
     * @return boolean
     */
    public function insert($data)
    {
        $ram = new ServerRamEntity();
        $ram->setServer($data['server']);
        $ram->setUser($data['user']);
        $ram->setType($data['type']);
        $ram->setSize($data['size']);
        $this->entityManager->persist($ram);

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
        $ram = $this->getById($id);

        if( !empty($ram) && !empty($newData) ){
            if( isset($newData['type']) ){
                $ram->setType($newData['type']);
            }
            if( isset($newData['size']) ){
                $ram->setSize($newData['size']);
            }

            $this->entityManager->flush();

            return true;
        }

        return false;
    }

    /**
     * Delete by id
     *
     * @param integer $id
     * @return boolean
     */
    public function deleteById($id)
    {
        $ram = $this->getById($id);

        if( !empty($ram) ){
            $this->entityManager->remove($ram);
            $this->entityManager->flush();

            return true;
        }

        return false;
    }
}