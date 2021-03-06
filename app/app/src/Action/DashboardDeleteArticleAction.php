<?php

namespace App\Action;

use Slim\Views\Twig;
use Slim\Router;
use Psr\Log\LoggerInterface;
use Slim\Http\Request;
use Slim\Http\Response;

final class DashboardDeleteArticleAction
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

    $article = $this->db->prepare("DELETE FROM articles WHERE id=:id");
    $article->bindValue('id', $id);
    $article->execute();

    $del=$this->db->prepare("DELETE FROM category WHERE article_id=:id");
    $del->bindValue('id',$id);
    $del->execute();

    return $response->withRedirect($this->router->pathFor('dashboardarticles'), 301); // 301 = façon dont il redirige exemple = error 404
  }
}