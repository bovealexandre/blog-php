<?php

namespace App\Action;

use Slim\Views\Twig;
use Slim\Router;
use Psr\Log\LoggerInterface;
use Slim\Http\Request;
use Slim\Http\Response;

final class DeleteCommentAction
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

    $id =$args['id'];
    $articleid= $args['articleid'];

    $article = $this->db->prepare("DELETE FROM comments WHERE id =:id");
    $article->bindValue('id', $id, \PDO::PARAM_INT);  
    $article->execute();

    return $response->withRedirect($this->router->pathFor('dashboardeditarticle', ['id' => $articleid] ), 301); // 301 = façon dont il redirige exemple = error 404
    
  }
}