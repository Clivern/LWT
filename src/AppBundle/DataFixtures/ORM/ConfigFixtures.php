<?php

namespace AppBundle\DataFixtures\ORM;

use AppBundle\Entity\Config;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;

/**
 * Defines the sample configs to load in the database before running the unit and
 * functional tests. Execute this command to load the data.
 *
 *   $ php bin/console doctrine:fixtures:load
 *
 * @package AppBundle\DataFixtures\ORM
 */
class ConfigFixtures extends Fixture
{

    /**
     * {@inheritdoc}
     */
    public function load(ObjectManager $manager)
    {

        $configs = [
            [ 'config_key' => '_site_title', 'config_value' => 'LWT', 'autoload' => 'on' ],
            [ 'config_key' => '_site_email', 'config_value' => 'hello@lwt.com', 'autoload' => 'on' ],
            [ 'config_key' => '_site_emails_sender', 'config_value' => 'no_reply@lwt.com', 'autoload' => 'on' ],
            [ 'config_key' => '_site_url', 'config_value' => 'http://lwt.com', 'autoload' => 'on' ],
            [ 'config_key' => '_site_keywords', 'config_value' => '', 'autoload' => 'on' ],
            [ 'config_key' => '_site_description', 'config_value' => '', 'autoload' => 'on' ],
            [ 'config_key' => '_site_lang', 'config_value' => 'en_US', 'autoload' => 'on' ],
            [ 'config_key' => '_site_timezone', 'config_value' => 'America/New_York', 'autoload' => 'on' ],
            [ 'config_key' => '_site_maintainance_mode', 'config_value' => 'off', 'autoload' => 'on' ],
            [ 'config_key' => '_site_custom_styles', 'config_value' => '', 'autoload' => 'on' ],
            [ 'config_key' => '_site_custom_scripts', 'config_value' => '', 'autoload' => 'on' ],
            [ 'config_key' => '_site_tracking_codes', 'config_value' => '', 'autoload' => 'on' ],
            [ 'config_key' => '_cron_key', 'config_value' => substr(md5(rand()), 0, 20) . substr(md5(rand()), 0, 20), 'autoload' => 'on' ],
            [ 'config_key' => '_api_refresh_token', 'config_value' => password_hash(substr(md5(rand()), 0, 20), PASSWORD_DEFAULT), 'autoload' => 'on' ],
            [ 'config_key' => '_api_refresh_token_expire', 'config_value' => time() + (14 * 24 * 60 * 60), 'autoload' => 'on' ],
            [ 'config_key' => '_api_old_refresh_token', 'config_value' => password_hash(substr(md5(rand()), 0, 20), PASSWORD_DEFAULT), 'autoload' => 'on' ],
        ];

        foreach ($configs as $config) {
            $config_entity = new Config();
            $config_entity->setConfigKey($config['config_key']);
            $config_entity->setConfigValue($config['config_value']);
            $config_entity->setAutoload($config['autoload']);
            $manager->persist($config_entity);
        }

        $manager->flush();
    }
}