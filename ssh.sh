#!/bin/bash

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

read -p "Tapez le nom du serveur de votre base de données : " bddserver
read -p "Tapez le nom de votre base de données : " bddname
read -p "Tapez le nom d utilisateur de votre base de données : " bddusername
read -p "Tapez le mot de passe de votre base de données : " bddpass
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

                printf "$type\n"