<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * User
 *
 * @ORM\Table(name="user")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\UserRepository")
 */
class User
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
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=60)
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="username", type="string", length=60, unique=true)
     */
    private $username;

    /**
     * @var string
     *
     * @ORM\Column(name="email", type="string", length=60, unique=true)
     */
    private $email;

    /**
     * @var string
     *
     * @ORM\Column(name="password", type="string", length=255)
     */
    private $password;

    /**
     * @var string
     *
     * @ORM\Column(name="status", type="string", length=15)
     */
    private $status;

    /**
     * @var string
     *
     * @ORM\Column(name="api_token", type="string", length=150, unique=true)
     */
    private $apiToken;

    /**
     * @var string
     *
     * @ORM\Column(name="api_token_expire", type="string", length=60)
     */
    private $apiTokenExpire;

    /**
     * @var string
     *
     * @ORM\Column(name="remember_token", type="string", length=255, unique=true)
     */
    private $rememberToken;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="created_at", type="datetime")
     */
    private $createdAt;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="updated_at", type="datetime")
     */
    private $updatedAt;

    /**
     * One User has Many Metas.
     *
     * @ORM\OneToMany(targetEntity="UserMeta", mappedBy="user", cascade={"persist", "remove"})
     */
    private $metas;

    /**
     * One User has Many Servers.
     *
     * @ORM\OneToMany(targetEntity="Server", mappedBy="user", cascade={"persist", "remove"})
     */
    private $servers;


    /**
     * One User has Many Rams.
     *
     * @ORM\OneToMany(targetEntity="ServerRam", mappedBy="user", cascade={"persist", "remove"})
     */
    private $server_rams;


    /**
     * Class Constructor
     */
    public function __construct()
    {
        $this->createdAt = new \DateTime();
        $this->updatedAt = new \DateTime();
        $this->metas = new ArrayCollection();
        $this->servers = new ArrayCollection();
        $this->server_rams = new ArrayCollection();
    }

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
     * Set name
     *
     * @param string $name
     *
     * @return User
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set username
     *
     * @param string $username
     *
     * @return User
     */
    public function setUsername($username)
    {
        $this->username = $username;

        return $this;
    }

    /**
     * Get username
     *
     * @return string
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * Set email
     *
     * @param string $email
     *
     * @return User
     */
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Get email
     *
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set password
     *
     * @param string $password
     *
     * @return User
     */
    public function setPassword($password)
    {
        $this->password = $password;

        return $this;
    }

    /**
     * Get password
     *
     * @return string
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * Set status
     *
     * @param string $status
     *
     * @return User
     */
    public function setStatus($status)
    {
        $this->status = $status;

        return $this;
    }

    /**
     * Get status
     *
     * @return string
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * Set apiToken
     *
     * @param string $apiToken
     *
     * @return User
     */
    public function setApiToken($apiToken)
    {
        $this->apiToken = $apiToken;

        return $this;
    }

    /**
     * Get apiToken
     *
     * @return string
     */
    public function getApiToken()
    {
        return $this->apiToken;
    }

    /**
     * Set apiTokenExpire
     *
     * @param string $apiTokenExpire
     *
     * @return User
     */
    public function setApiTokenExpire($apiTokenExpire)
    {
        $this->apiTokenExpire = $apiTokenExpire;

        return $this;
    }

    /**
     * Get apiTokenExpire
     *
     * @return string
     */
    public function getApiTokenExpire()
    {
        return $this->apiTokenExpire;
    }

    /**
     * Set rememberToken
     *
     * @param string $rememberToken
     *
     * @return User
     */
    public function setRememberToken($rememberToken)
    {
        $this->rememberToken = $rememberToken;

        return $this;
    }

    /**
     * Get rememberToken
     *
     * @return string
     */
    public function getRememberToken()
    {
        return $this->rememberToken;
    }

    /**
     * Set createdAt
     *
     * @param \DateTime $createdAt
     *
     * @return User
     */
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    /**
     * Get createdAt
     *
     * @return \DateTime
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * Set updatedAt
     *
     * @param \DateTime $updatedAt
     *
     * @return User
     */
    public function setUpdatedAt($updatedAt)
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    /**
     * Get updatedAt
     *
     * @return \DateTime
     */
    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }

    /**
     * Get Metas
     *
     * @return ArrayCollection
     */
    public function getMetas()
    {
        return $this->metas;
    }

    /**
     * Add Meta
     *
     * @param UserMeta $meta
     * @return void
     */
    public function addMeta(UserMeta $meta)
    {
        $meta->setUser($this);
        if (!$this->metas->contains($meta)) {
            $this->metas->add($meta);
        }
    }

    /**
     * Remove Meta
     *
     * @param  UserMeta $meta
     * @return void
     */
    public function removeMeta(UserMeta $meta)
    {
        $meta->setUser(null);
        $this->metas->removeElement($meta);
    }

    /**
     * Get Servers
     *
     * @return ArrayCollection
     */
    public function getServers()
    {
        return $this->servers;
    }

    /**
     * Add Server
     *
     * @param Server $server
     * @return void
     */
    public function addServer(Server $server)
    {
        $server->setUser($this);
        if (!$this->servers->contains($server)) {
            $this->servers->add($server);
        }
    }

    /**
     * Remove Server
     *
     * @param  Server $server
     * @return void
     */
    public function removeServer(Server $server)
    {
        $server->setUser(null);
        $this->servers->removeElement($server);
    }

    /**
     * Get Rams
     *
     * @return ArrayCollection
     */
    public function getServerRams()
    {
        return $this->server_rams;
    }

    /**
     * Add Ram
     *
     * @param ServerRam $server_ram
     * @return void
     */
    public function addServerRam(ServerRam $server_ram)
    {
        $server_ram->setUser($this);
        if (!$this->server_rams->contains($server_ram)) {
            $this->server_rams->add($server_ram);
        }
    }

    /**
     * Remove Ram
     *
     * @param  ServerRam $server_ram
     * @return void
     */
    public function removeServerRam(ServerRam $server_ram)
    {
        $server_ram->setUser(null);
        $this->server_rams->removeElement($server_ram);
    }
}

