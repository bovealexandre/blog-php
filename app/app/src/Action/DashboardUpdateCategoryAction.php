<?php

namespace App\Action;

use Slim\Views\Twig;
use Slim\Router;
use Psr\Log\LoggerInterface;
use Slim\Http\Request;
use Slim\Http\Response;

final class DashboardUpdateCategoryAction
{
    private $view;
    private $logger;
    private $db;
    private $router;

    public function __construct(Twig $view, LoggerInterface $logger, $db, Router $router)
    {
        $this->view = $view;
        $this->logger = $logger;
        $this->db = $db;
        $this->router = $router;
    }

    public function __invoke(Request $request, Response $response, $args)
    {     
      $this->logger->info("Dashboard categories page action dispatched");
      $id = $args['id'];
      $nom = $request->getParsedBody()['name'];
      $nom = $request->getParsedBody()['image']; //checks _POST [IS PSR-7 compliant]

      $user = $this->db->prepare('UPDATE categories SET nom=:nom image=:image WHERE id=:id');
      $user->bindParam("id", $id);
      $user->bindValue('nom', $nom,  \PDO::PARAM_STR);
      $user->bindValue('image', $image,  \PDO::PARAM_STR);
      $user->execute();
        
      return $response->withRedirect($this->router->pathFor('dashboardcategories'), 301);
    }
  }