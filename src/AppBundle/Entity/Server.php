<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Server
 *
 * @ORM\Table(name="server")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\ServerRepository")
 */
class Server
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
     * @ORM\Column(name="asset_id", type="bigint", unique=true)
     */
    private $assetId;

    /**
     * @var int
     *
     * @ORM\Column(name="user_id", type="integer")
     */
    private $userId;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=20)
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="brand", type="string", length=20)
     */
    private $brand;

    /**
     * @var string
     *
     * @ORM\Column(name="price", type="decimal", precision=4, scale=10)
     */
    private $price;

    /**
     * Many Servers have One User.
     * @ORM\ManyToOne(targetEntity="User", inversedBy="servers")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id")
     */
    private $user;

    /**
     * One User has Many Metas.
     * @ORM\OneToMany(targetEntity="ServerRam", mappedBy="server", cascade={"persist", "remove"})
     */
    private $rams;

    /**
     * Class Constructor
     */
    public function __construct()
    {
        $this->rams = new ArrayCollection();
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
     * Set assetId
     *
     * @param integer $assetId
     *
     * @return Server
     */
    public function setAssetId($assetId)
    {
        $this->assetId = $assetId;

        return $this;
    }

    /**
     * Get assetId
     *
     * @return int
     */
    public function getAssetId()
    {
        return $this->assetId;
    }

    /**
     * Set userId
     *
     * @param integer $userId
     *
     * @return Server
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
     * Set name
     *
     * @param string $name
     *
     * @return Server
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
     * Set brand
     *
     * @param string $brand
     *
     * @return Server
     */
    public function setBrand($brand)
    {
        $this->brand = $brand;

        return $this;
    }

    /**
     * Get brand
     *
     * @return string
     */
    public function getBrand()
    {
        return $this->brand;
    }

    /**
     * Set price
     *
     * @param string $price
     *
     * @return Server
     */
    public function setPrice($price)
    {
        $this->price = $price;

        return $this;
    }

    /**
     * Get price
     *
     * @return string
     */
    public function getPrice()
    {
        return $this->price;
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
     * Get Rams
     *
     * @return ArrayCollection
     */
    public function getRams()
    {
        return $this->rams;
    }

    /**
     * Add Meta
     *
     * @param ServerRam $ram
     * @return void
     */
    public function addRam(ServerRam $ram)
    {
        $ram->setServer($this);
        if (!$this->rams->contains($ram)) {
            $this->rams->add($ram);
        }
    }

    /**
     * Remove Meta
     *
     * @param  ServerRam $ram
     * @return void
     */
    public function removeRam(ServerRam $ram)
    {
        $ram->setServer(null);
        $this->rams->removeElement($ram);
    }
}

