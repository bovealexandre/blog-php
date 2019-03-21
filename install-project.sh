#!/bin/bash


while read -p "Entrer le type d installation (locale (tapez locale) ou sur un serveur SSH (tapez ssh)) : " type; do
# printf 'Entrer le type d installation (locale (tapez locale) ou sur un serveur SSH (tapez ssh)) : '
# read $type


case $type in
          "locale")
                read -p "Tapez le nom de votre projet : " projectname
                git clone https://github.com/bovealexandre/blog-php.git $projectname
                cd $projectname

                cat >> .htaccess <<EOL
# For production, put your rewrite rules directly into your VirtualHost
# directive and turn off AllowOverride.

<IfModule mod_rewrite.c>
    RewriteEngine On

    RewriteCond %{REQUEST_FILENAME} -s [OR]
    RewriteCond %{REQUEST_FILENAME} -l [OR]
    RewriteCond %{REQUEST_FILENAME} -d
    RewriteRule ^.*$ - [NC,L]


    RewriteCond %{REQUEST_URI}::$1 ^(/.+)(.+)::\2$
    RewriteRule ^(.*) - [E=BASE:%1]
    RewriteRule ^(.*)$ %{ENV:BASE}index.php [NC,L]
</IfModule>
EOL

read -p "Tapez le nom de votre base de données : " bddname
read -p "Tapez le nom d utilisateur de votre base de données : " bddusername
read -p "Tapez le mot de passe de votre base de données : " bddpass

if [ -f docker-compose.yml ]; then
    rm -rf docker-compose.yml
fi
cat >> docker-compose.yml <<EOL
version: '3.1'

services:

  # La base de données PostgreSQL. Elle est configurée de façon à être joignable sur
  # localhost:5432 .
  # 
  # Utilisateur: $bddusername
  # Mot de passe: $bddpass
  # Base de données par défault: $bddname

  db:
    image: postgres:11.2
    ports:
      - "5432:5432"
    volumes:
      - ./db.sql:/docker-entrypoint-initdb.d/db.sql
      - dbvolume:/var/lib/postgresql/data
    environment:
      POSTGRES_USER: $bddusername
      POSTGRES_PASSWORD: $bddpass
      POSTGRES_DB: $bddname

  # Un serveur Adminer pour pouvoir tester les fonctionnalités de la base de données et
  # faire du debugging. Il est joignable avec un simple browser en utilisant http://localhost:9000 .
  # 
  # Voir la configuration de PostgreSQL pour les accès.

  adminer:
    image: adminer:4.7
    depends_on:
      - db
    ports:
      - "9000:8080"

# Un volume nommé pour stocker le contenu de la base de données PostgreSQL. De cette façon
# le contenu de la base de données ne sera pas effacé à chaque lancement des services.
#
# Pour le cleaner il suffit de faire un `docker-compose down -v` suivi d'un
# `docker-compose up`.

volumes:
  dbvolume:
EOL


cd app/app
if [ -f settings.php ]; then
    rm -rf settings.php
fi
cat >> settings.php <<EOL
<?php
return [
    'settings' => [
        // Slim Settings
        'determineRouteBeforeAppMiddleware' => false,
        'displayErrorDetails' => true,

        // View settings
        'view' => [
            'template_path' => __DIR__ . '/templates',
            'twig' => [
                'cache' => false, // __DIR__ . '/../cache/twig',
                'debug' => true,
                'auto_reload' => true,
            ],
        ],

        // monolog settings
        'logger' => [
            'name' => 'app',
            'path' => __DIR__ . '/log/app.log',
        ],
        'db'=>[
            'driver'    => 'pgsql',
            'host'      => 'localhost',
            'database'  => '$bddname',
            'username'  => '$bddusername',
            'password'  => '$bddpass',
            'charset'   => 'utf8',
            'collation' => 'utf8_unicode_ci',
            'prefix'    => '',
        ]
    ],
];
EOL
                cd ../..
                npm install
                cd app
                composer install

                printf "$type\n"
                break;;
          "ssh")
                read -p  "Tapez votre nom d utilisateur sur le serveur SSH : " name
                read -p "Tapez le nom du serveur SSH : " server
                read -p "Tapez le nom du serveur de votre base de données : " bddserver
                read -p "Tapez le nom de votre base de données : " bddname
                read -p "Tapez le nom d utilisateur de votre base de données : " bddusername
                read -p "Tapez le mot de passe de votre base de données : " bddpass
                ssh $name@$server <<EOF
                rm -rf public_html
                git clone https://github.com/bovealexandre/blog-php.git public_html
                cd public_html
                cat >> .htaccess <<EOL
# For production, put your rewrite rules directly into your VirtualHost
# directive and turn off AllowOverride.

<IfModule mod_rewrite.c>
    RewriteEngine On

    RewriteCond %{REQUEST_FILENAME} -s [OR]
    RewriteCond %{REQUEST_FILENAME} -l [OR]
    RewriteCond %{REQUEST_FILENAME} -d
    RewriteRule ^.*$ - [NC,L]


    RewriteCond %{REQUEST_URI}::$1 ^(/.+)(.+)::\2$
    RewriteRule ^(.*) - [E=BASE:%1]
    RewriteRule ^(.*)$ %{ENV:BASE}index.php [NC,L]
</IfModule>
EOL


cd app/app
if [ -f settings.php ]; then
    rm -rf settings.php
fi
cat >> settings.php <<EOL
<?php
return [
    'settings' => [
        // Slim Settings
        'determineRouteBeforeAppMiddleware' => false,
        'displayErrorDetails' => true,

        // View settings
        'view' => [
            'template_path' => __DIR__ . '/templates',
            'twig' => [
                'cache' => false, // __DIR__ . '/../cache/twig',
                'debug' => true,
                'auto_reload' => true,
            ],
        ],

        // monolog settings
        'logger' => [
            'name' => 'app',
            'path' => __DIR__ . '/log/app.log',
        ],
        'db'=>[
            'driver'    => 'pgsql',
            'host'      => '$bddserver',
            'database'  => '$bddname',
            'username'  => '$bddusername',
            'password'  => '$bddpass',
            'charset'   => 'utf8',
            'collation' => 'utf8_unicode_ci',
            'prefix'    => '',
        ]
    ],
];
EOL
                cd ../..
                npm install
                cd app
                composer install
                chmod a+rxw app/log/app.log
                printf "$type\n"
EOF
                break;;
          *)
                printf 'Entrer le type d installation (locale (tapez locale) ou sur un serveur SSH (tapez ssh)) : '
                read $type
                ;;
esac
done

