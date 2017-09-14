<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * ServerRam
 *
 * @ORM\Table(name="server_ram")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\ServerRamRepository")
 */
class ServerRam
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var int
     *
     * @ORM\Column(name="server_id", type="integer")
     */
    private $serverId;

    /**
     * @var int
     *
     * @ORM\Column(name="user_id", type="integer")
     */
    private $userId;

    /**
     * @var string
     *
     * @ORM\Column(name="type", type="string", length=20)
     */
    private $type;

    /**
     * @var int
     *
     * @ORM\Column(name="size", type="integer")
     */
    private $size;

    /**
     * Many Rams have One User.
     * @ORM\ManyToOne(targetEntity="User", inversedBy="server_rams")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id")
     */
    private $user;

    /**
     * Many Rams have One Server.
     * @ORM\ManyToOne(targetEntity="Server", inversedBy="rams")
     * @ORM\JoinColumn(name="server_id", referencedColumnName="id")
     */
    private $server;


    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set serverId
     *
     * @param integer $serverId
     *
     * @return ServerRam
     */
    public function setServerId($serverId)
    {
        $this->serverId = $serverId;

        return $this;
    }

    /**
     * Get serverId
     *
     * @return int
     */
    public function getServerId()
    {
        return $this->serverId;
    }

    /**
     * Set userId
     *
     * @param integer $userId
     *
     * @return ServerRam
     */
    public function setUserId($userId)
    {
        $this->userId = $userId;

        return $this;
    }

    /**
     * Get userId
     *
     * @return int
     */
    public function getUserId()
    {
        return $this->userId;
    }

    /**
     * Set type
     *
     * @param string $type
     *
     * @return ServerRam
     */
    public function setType($type)
    {
        $this->type = $type;

        return $this;
    }

    /**
     * Get type
     *
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Set size
     *
     * @param integer $size
     *
     * @return ServerRam
     */
    public function setSize($size)
    {
        $this->size = $size;

        return $this;
    }

    /**
     * Get size
     *
     * @return int
     */
    public function getSize()
    {
        return $this->size;
    }

    /**
     * Get User
     *
     * @return User
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * Set User
     *
     * @param User $user
     * @return void
     */
    public function setUser(User $user)
    {
        $this->user = $user;
    }

    /**
     * Get Server
     *
     * @return Server
     */
    public function getServer()
    {
        return $this->server;
    }

    /**
     * Set Server
     *
     * @param Server $server
     * @return void
     */
    public function setServer(Server $server)
    {
        $this->server = $server;
    }
}

