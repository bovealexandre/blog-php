<?php

namespace App\Action;

use Slim\Views\Twig;
use Psr\Log\LoggerInterface;
use Slim\Http\Request;
use Slim\Http\Response;

final class CreateCategoryAction
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
    $data = $request->getParsedBody();
    $nom =$data['name'];

    $category = $this->db->prepare('INSERT INTO categories(nom) VALUES (:nom)');
    $category->bindValue('nom', $nom, \PDO::PARAM_STR); 
    $category->execute();

    return $response->withRedirect('/dashboard/categories', 301); // 301 = façon dont il redirige exemple = error 404
  }
}