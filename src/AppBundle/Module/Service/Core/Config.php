<?php

namespace AppBundle\Module\Service\Core;

use AppBundle\Module\Contract\Core\Config as ConfigContract;
use Doctrine\ORM\EntityManager;
use AppBundle\Entity\Config as ConfigEntity;

/**
 * Config Service
 *
 * @package AppBundle\Module\Service\Core
 */
class Config implements ConfigContract
{

    /**
     * @var array
     */
    protected $configs = [];

    /**
     * @var EntityManager
     */
    protected $entity_manager;

    /**
     * Service Constructor
     *
     * @param EntityManager $entity_manager
     */
    public function __construct(EntityManager $entity_manager)
    {
        $this->entity_manager = $entity_manager;
    }

    /**
     * Insert a new config
     *
     * @param  string $key
     * @param  mixed $value
     * @param  string $autoload
     * @return boolean
     */
    public function insert($key, $value, $autoload = 'off')
    {
        $config = new ConfigEntity();
        $config->setConfigKey($key);
        $config->setConfigValue((is_array($value)) ? serialize($value) : $value);
        $config->setAutoload($autoload);

        $this->entity_manager->persist($config);

        $this->entity_manager->flush();

        return true;
    }

    /**
     * Autoload configs
     *
     * @param  string $type
     * @return boolean
     */
    public function autoload($type = 'on')
    {
        $configs = $this->entity_manager->getRepository(ConfigEntity::class)->findBy(['autoload' => $type]);

        foreach ($configs as $config) {
            $this->configs[$config->getConfigKey()] = $config->getConfigValue();
        }

        return true;
    }

    /**
     * Get config by key
     *
     * @param  string  $key
     * @param  boolean $default
     * @return mixed
     */
    public function getByKey($key, $default = false)
    {
        if( isset($this->configs[$key]) ){
            return $this->configs[$key];
        }

        $config = $this->entity_manager->getRepository(ConfigEntity::class)->findOneBy(['configKey' => $key]);

        if( !empty($config) ){
            $this->configs[$key] = $config->getConfigValue();
            return $this->configs[$key];

        }
        $this->configs[$key] = $default;

        return $default;
    }

    /**
     * Update config by key
     *
     * @param  string  $key
     * @param  mixed $value
     * @return boolean
     */
    public function updateByKey($key, $value)
    {
        $config = $this->entity_manager->getRepository(ConfigEntity::class)->findOneBy(['configKey' => $key]);

        if( !empty($config) ){
            $value = (is_array($value)) ? serialize($value) : $value;
            $config->setConfigValue($value);
            $this->entity_manager->flush();

            return true;
        }

        return false;
    }

    /**
     * Update config by id
     *
     * @param  integer  $id
     * @param  mixed $value
     * @return boolean
     */
    public function updateById($id, $value)
    {
        $config = $this->entity_manager->getRepository(ConfigEntity::class)->findOneBy(['id' => $id]);

        if( !empty($config) ){
            $value = (is_array($value)) ? serialize($value) : $value;
            $config->setConfigValue($value);
            $this->entity_manager->flush();
            return true;
        }

        return false;
    }

    /**
     * Update Refersh Token if Expired
     *
     * @return boolean
     */
    public function updateRefreshToken()
    {
        $current_time = time();
        $api_refresh_token = $this->getByKey('_api_refresh_token');
        $api_refresh_token_expire = $this->getByKey('_api_refresh_token_expire');
        $old_refresh_token = $this->getByKey('_api_old_refresh_token');

        // Check if token expired
        if( time() > $api_refresh_token_expire ){

            // refresh tokens
            $new_token = password_hash(substr(md5(rand()), 0, 20), PASSWORD_DEFAULT);
            $new_time = time() + (14 * 24 * 60 * 60);
            $old_token = $api_refresh_token;

            if( $this->updateByKey('_api_refresh_token', $new_token) ){
                $this->configs['_api_refresh_token'] = $new_token;
            }
            if( $this->updateByKey('_api_refresh_token_expire', $new_time) ){
                $this->configs['_api_refresh_token_expire'] = $new_time;
            }
            if( $this->updateByKey('_api_old_refresh_token', $old_token) ){
                $this->configs['_api_old_refresh_token'] = $old_token;
            }
        }

        return true;
    }

    /**
     * Delete config by id
     *
     * @param  integer $id
     * @return boolean
     */
    public function deleteById($id)
    {
        $config = $this->entity_manager->getRepository(ConfigEntity::class)->findOneBy(['id' => $id]);

        if( !empty($config) ){
            $this->entity_manager->remove($config);
            $this->entity_manager->flush();

            return true;
        }

        return false;
    }

    /**
     * Delete config by key
     *
     * @param  string $key
     * @return boolean
     */
    public function deleteByKey($key)
    {
        $config = $this->entity_manager->getRepository(ConfigEntity::class)->findOneBy(['configKey' => $key]);

        if( !empty($config) ){
            $this->entity_manager->remove($config);
            $this->entity_manager->flush();

            return true;
        }

        return false;
    }
}