# Blog-PHP

Blog-PHP is a becode project. We had to do. It consists in a blog written in Slim and Twig.

## Installation

To install the package just launch the bash script that you can download in the repository

```bash
bash install-project.sh
```

then it will ask you some questions like do you want to install it in SSH or local

#### Local

1. If you typed locale then it will ask you the name of your project and it will extract the project on the file you are on your terminal.

2. It will ask you to initialize your Database (db name, db user, db password).

3. You can go into your database and import the "bdd.sql"

#### SSH

1. If you typed SSH then it will ask you your username on the server and the server.

2. It will ask you to initialize your Database (db server, db name, db user, db password).

3. You can go into your database and import the "bdd.sql"

## Usage


### How to use

```
* app/
  * app/
    * log/
      * app.log
    * src/
      * Action/
        * Contain all the actions
      * Middlewares/
        * Contain all the middlewares
    * templates/
      * Contain all the templates for your pages
    * dependencies.php
    * middleware.php
    * routes.php
    * settings.php
  * public/
    * css/
      * admin.css
      * bootstrap.css
      * master.css
    * js/
      * bootstrap.js
      * jquery.js
      * popper.js
    * index.php
    * .htaccess
  * composer.json
  * composer.lock
* dist/
  * scss/
    * admin.scss
    * master.scss
* db/
* docker-compose.yml
* gulpfile.js
* index.php
* package.json
```

To create a new page or action put it in app/src/action

with  **your action**.php

```
<?php

namespace App\Action;

use Slim\Views\Twig;
use Psr\Log\LoggerInterface;
use Slim\Http\Request;
use Slim\Http\Response;
use Slim\Http\UploadedFile;

final class YourAction
{
  private $view;
  private $logger;
  private $db;

  public function __construct(Twig $view, LoggerInterface $logger,$db)
  {
      $this->view = $view;
      $this->logger = $logger;
      $this->db=$db;
  }

  public function __invoke(Request $request, Response $response, $args)
  {
    $id=$this->db->prepare('YourSqlRequest');
    $id->execute();

    return $response->withRedirect('/', 301, $args);


  }
 }

```

#### Local

Just type gulp in the terminal and it will launch your PHP server, PostgreSQL server, Adminer and compile your CSS with SASS.

You then can access to your website through the port 8080 and the database through the port 9000.

To access the admin dashboard with the admin account the password is admin and then change your password.

#### SSH

Just type gulp sass in the terminal and it will compile your CSS with SASS.

To access the admin dashboard with the admin account the password is admin and then change your password.

## Contributing

- Lara Loicq
- Christophe Bral
- Alexandre Bove

## License
[MIT](https://choosealicense.com/licenses/mit/)