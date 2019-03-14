<?php

namespace App\Action;

use Slim\Views\Twig;
use Slim\Router;
use Psr\Log\LoggerInterface;
use Slim\Http\Request;
use Slim\Http\Response;

final class CreateCategoryAction
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
    $data = $request->getParsedBody();
    $nom =$data['name'];
    $image =$data['image'];

    $category = $this->db->prepare('INSERT INTO categories(nom,image) VALUES (:nom,:image)');
    $category->bindValue('nom', $nom, \PDO::PARAM_STR); 
    $category->bindValue('image', $image, \PDO::PARAM_STR); 
    $category->execute();

    return $response->withRedirect($this->router->pathFor('dashboardcategories'), 301); // 301 = façon dont il redirige exemple = error 404
  }
}