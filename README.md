## LWT

:wolf: Simple ERP Application In Symfony.

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

Open your browser and access the `http://localhost:8000/`

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
```
#
```

Alternative
-----------

```
#
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