<?php

namespace App\Action;

use Slim\Views\Twig;
use Slim\Router;
use Psr\Log\LoggerInterface;
use Slim\Http\Request;
use Slim\Http\Response;

final class DashboardDeleteCategoryAction
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

      $user = $this->db->prepare('DELETE FROM categories WHERE id=:id');
      $user->bindParam("id", $id);
      $user->execute();
        
      return $response->withRedirect($this->router->pathFor('dashboardcategories'), 301);
    }
  }