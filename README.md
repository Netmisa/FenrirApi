README
======

Requirements
-------------

- php5, php5-pgsql librairies
- git
- composer
- postGreSQL database

Installation
-------------

### 1. Clone the repository

    git clone git@github.com:CanalTP/FenrirApi.git

### 2. Install dependencies

    curl -sS https://www.getcomposer.org/installer | php
    composer.phar install

### 3. Set permissions to cache, logs and uploads directories

    sudo setfacl -R -m u:www-data:rwX -m u:`whoami`:rwX var/cache var/logs
    sudo setfacl -dR -m u:www-data:rwx -m u:`whoami`:rwx var/cache var/logs

### 4. Create in app/config/ folder your own config files based on *.dist ones

    parameters.yml

### 5. Database

    php bin/console doctrine:database:create
    php bin/console doctrine:schema:update --force

VHOST
------


You have the choice to make of two ways:

## 1. Runs PHP built-in web server

### 1.1 Run

    php bin/console server:run

Then, click on: [http://127.0.0.1:8000/users](http://127.0.0.1:8000/users)

## 2. Vhost Apache

### 2.1 Create

    /etc/apache2/sites-available/fenrir-api.local.conf

    <VirtualHost *:80>
        ServerAdmin webmaster@localhost
        ServerName fenrir-api.local.fr 

        DirectoryIndex app_dev.php
        DocumentRoot _PATH_/FenrirApi/web/

        <Directory _PATH_/FenrirApi/web>
            AllowOverride All
            Allow from All

            RewriteEngine On
            RewriteRule !\.(css|less|jst?|ico|png|jpg|jpeg|gif|xml|xsl|swf|htm|php)$ app_dev.php
            RewriteRule ^javascript/(.*\.jst?)$ javascript/$1 [L,NC]
            RewriteRule ^images/(.*\.(ico|jpe?g|png|gif))$ images/$1 [L,NC]
            RewriteRule ^css/(.*\.css|less)$ css/$1 [L,NC]
        </Directory>

        ErrorLog /var/log/apache2/fenrir-api.local.error.log
        AddDefaultCharset utf-8
    </VirtualHost>


### 2.2 Enable

    - sudo a2ensite fenrir-api.local.conf
    - sudo /etc/init.d/apache2 restart


### 2.3 Add host

    - Add host 'fenrir-api.local.conf' to file '/etc/hosts'

Contributing
-------------

1. Ludovic Roche <https://github.com/lrocheWB>
2. Rémy Abi-khalil <https://github.com/netmisa>
3. Julien Maulny <https://github.com/alcalyn>
