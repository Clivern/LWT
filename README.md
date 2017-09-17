## LWT

:wolf: Simple ERP Application Skelton In Symfony 3.3.9.

*Current version: Under Development*

[![Build Status](https://travis-ci.org/Clivern/LWT.svg?branch=master)](https://travis-ci.org/Clivern/LWT)

## Installation

In order to run this app do the following:

1-Minute Install
----------------
- Get the application code and install php dependencies and node packages.
```bash
git clone https://github.com/Clivern/LWT.git lwt
cd lwt
composer install
npm install
```

- Open `app/config/parameters.yml` and insert your MySQL database credentials. Let's say it will be look like this:
```yaml
parameters:
    database_host: 127.0.0.1
    database_port: null
    database_name: homestead
    database_user: homestead
    database_password: secret
    mailer_transport: smtp
    mailer_host: 127.0.0.1
    mailer_user: null
    mailer_password: null
    secret: ThisTokenIsNotSoSecretChangeIt
```

- Run the following command to build database tables
```bash
php bin/console doctrine:schema:update --force
```

- Run the following command to seed our database with one user and default configs
```bash
php bin/console doctrine:fixtures:load
```

- We are ready to run our application
```bash
php bin/console server:run
```

Open your browser and access the `http://127.0.0.1:8000`

*Please Note That* You can login with `clivern/clivern` As we already imported that user in previous steps.


With Vagrant
------------
Please note that `vagrant` need a provider in order to run the `VM`. In this project, I use `VirtualBox` as provider.
After you have `vagrant` and `VirtualBox` up and running, do the following steps:

- Get the application code and install php dependencies and node packages.
```bash
git clone https://github.com/Clivern/LWT.git lwt
cd lwt
composer install
npm install
vagrant up
```

- Open `app/config/parameters.yml` and insert your MySQL database credentials. Let's say it will be look like this (Also look at `app/config/parameters.yml.vagrant`):
```yaml
parameters:
    database_host: 127.0.0.1
    database_port: null
    database_name: homestead
    database_user: homestead
    database_password: secret
    mailer_transport: smtp
    mailer_host: 127.0.0.1
    mailer_user: null
    mailer_password: null
    secret: ThisTokenIsNotSoSecretChangeIt
```

- After Vagrant build and provision your machine, login into this machine to do some configs (build database tables and seed our database).
```bash
vagrant ssh
cd lwt
php bin/console doctrine:schema:update --force
php bin/console doctrine:fixtures:load
```

- Open your browser and access the `http://192.168.10.10`.

- Vagrant use `192.168.10.10` as project IP, so we need to redirect all requests coming to `lwt.com` to that IP. So add the following to your `/etc/hosts` file.
```bash
192.168.10.10       lwt.com
```

- To Stop vagrant machine, run the following
```bash
vagrant halt
```

Please feel free to check `Homestead.yaml` file in case you need to customize your vagrant machine.


With Docker
------------
- Get the application code and install php dependencies and node packages.
```bash
git clone https://github.com/Clivern/LWT.git lwt
cd lwt
npm install
```

- Then run our docker containers
```bash
docker-compose build
docker-compose up -d
```

- Then install our php dependencies with composer.
```bash
docker exec -it lwt_php bash -c "composer install && chown -R www-data /www/var"
```

- Open `app/config/parameters.yml` and insert your MySQL database credentials. Let's say it will be look like this (Also look at `app/config/parameters.yml.docker`):
```yaml
parameters:
    database_host: lwt_mysql
    database_port: 3306
    database_name: homestead
    database_user: homestead
    database_password: secret
    mailer_transport: smtp
    mailer_host: 127.0.0.1
    mailer_user: null
    mailer_password: null
    secret: ThisTokenIsNotSoSecretChangeIt
```

- Access our PHP container to build database tables and seed these tables
```bash
docker exec -it lwt_php bash
php bin/console doctrine:schema:update --force
php bin/console doctrine:fixtures:load
```

- Open your browser and access the `http://127.0.0.1:8001/`.

- Also you can add `http://lwt.dev` to your `/etc/hosts` file.
```bash
127.0.0.1:8001       lwt.dev
```

- To Check our containers, use the following command:
```bash
docker-compose ps
```

- To stop our containers
```bash
docker-compose down
```

[*Please check these docs to manage docker as a non-root user.*](https://docs.docker.com/engine/installation/linux/linux-postinstall/) because if it runs with the root user, you will have to use `sudo ...` in all previous commands.


Alternative
-----------
In case you have A LAMP environment on your machine, Please follow the following steps:

- Get the application code and install php dependencies and node packages.
```bash
git clone https://github.com/Clivern/LWT.git lwt
cd lwt
composer install
npm install
```

- Open `app/config/parameters.yml` and insert your MySQL database credentials. Let's say it will be look like this:
```yaml
parameters:
    database_host: 127.0.0.1
    database_port: null
    database_name: homestead
    database_user: homestead
    database_password: secret
    mailer_transport: smtp
    mailer_host: 127.0.0.1
    mailer_user: null
    mailer_password: null
    secret: ThisTokenIsNotSoSecretChangeIt
```

- Run the following command to build database tables
```bash
php bin/console doctrine:schema:update --force
```

- Run the following command to seed our database with one user and default configs
```bash
php bin/console doctrine:fixtures:load
```

- You need to create a [virtual host](http://symfony.com/doc/current/setup/web_server_configuration.html) for this project and have it always running.
```config
<VirtualHost *:80>
    ServerName lwt.com
    ServerAlias www.lwt.com

    DocumentRoot /var/www/lwt/web
    <Directory /var/www/lwt/web>
        AllowOverride All
        Order Allow,Deny
        Allow from All
    </Directory>
    ErrorLog /var/log/apache2/lwt_error.log
    CustomLog /var/log/apache2/lwt_access.log combined
</VirtualHost>

```

Please Don't forget to add lwt.com on your hosts file
```
127.0.1.6       lwt.com
```

Now when we visit `lwt.com` it should work!

## REST API
Application has a REST API to be used by frontend so you can use these APIs to build Single Page Application or even consume these APIs from other application or service.

- To create a server:
```bash
curl --request POST --url http://lwt.com/api/v1/server --header 'X-AUTH-TOKEN: api_token_here' --data 'name=R234&brand=HP&asset_id=123&price=200.35'
```

- To get your servers:
```bash
curl --request GET --url http://lwt.com/api/v1/server --header 'X-AUTH-TOKEN: api_token_here'
```

- To get server with id:
```bash
curl --request GET --url http://lwt.com/api/v1/server/{server_id} --header 'X-AUTH-TOKEN: api_token_here'
```

- To delete server with id:
```bash
curl --request DELETE --url http://lwt.com/api/v1/server/{server_id} --header 'X-AUTH-TOKEN: api_token_here'
```

- To get Server Rams:
```bash
curl --request GET --url http://lwt.com/api/v1/server/{server_id}/ram --header 'X-AUTH-TOKEN: api_token_here'
```

- To get Server Ram:
```bash
curl --request GET --url http://lwt.com/api/v1/server/{server_id}/ram/{ram_id} --header 'X-AUTH-TOKEN: api_token_here'
```

- To create Server Ram:
```bash
curl --request POST --url http://lwt.com/api/v1/server/{server_id}/ram --header 'X-AUTH-TOKEN: api_token_here' --data 'type=DDR3&size=2'
```

- To delete Server Ram:
```bash
curl --request DELETE --url http://lwt.com/api/v1/server/{server_id}/ram/{ram_id} --header 'X-AUTH-TOKEN: api_token_here'
```

- To get current refresh token:
```bash
curl --request GET --url http://lwt.com/api/v1/refresh_token --header 'X-AUTH-TOKEN: api_token_here'
```

- To Get your new API token in case it is expired:
```
curl --request POST --url http://lwt.com/api/v1/api_token --header 'X-AUTH-TOKEN: api_token_here' --data 'refresh_token=sgshdhd..'
```

## Misc

Notes
-----
- If the *npm install* command fails or hangs, Do the following.
```
sudo ln -s /usr/bin/nodejs /usr/bin/node
```

- To compile changes performed to JS or CSS code in `resources/assets/` dir, run the following command:
```
npm run dev
```

Testing
-------
To run test cases & get test coverage reports run the following command in app root
```bash
./vendor/bin/simple-phpunit --coverage-text=./coverage.txt --coverage-html ./coverage
```

or to view the coverage report
```bash
./vendor/bin/simple-phpunit --coverage-text --coverage-html ./coverage
```

Please note that, you need `xdebug` in order to get coverage reports.

Changelog
---------
Version 1.0.0:
```
Coming Soon :D
```

Acknowledgements
----------------

© 2017, Clivern. Released under the [MIT License](http://www.opensource.org/licenses/mit-license.php).

**LWT** is authored and maintained by [@clivern](http://github.com/clivern).