<?php

namespace App\Action;

use Slim\Views\Twig;
use Slim\Router;
use Psr\Log\LoggerInterface;
use Slim\Http\Request;
use Slim\Http\Response;

final class DashboardCreationArticleAction
{
  private $view;
  private $logger;
  private $db;
  private $router;

  public function __construct(Twig $view, LoggerInterface $logger,$db, Router $router)
  {
      $this->view = $view;
      $this->logger = $logger;
      $this->db=$db;
      $this->router = $router;
  }

  public function __invoke(Request $request, Response $response, $args)
  {
    $id=$args['id'];
    $data = $request->getParsedBody();
    $password =$data['password']; // récupérations de données, envoies dans les bindvalues

    $pass = $this->db->prepare('UPDATE users SET password=:password WHERE id=:id');
    $pass->bindValue('id', $id, \PDO::PARAM_STR); 
    $pass->bindValue('password', $password, \PDO::PARAM_STR); 
    $pass->execute();

    return $response->withRedirect($this->router->pathFor('dashboardarticles'), 301); // 301 = façon dont il redirige exemple = error 404
  }
}