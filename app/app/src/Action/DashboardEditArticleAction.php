<?php

namespace App\Action;

use Slim\Views\Twig;
use Psr\Log\LoggerInterface;
use Slim\Http\Request;
use Slim\Http\Response;

final class DashboardEditArticleAction
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
    $id=$args['id'];

    $art = $this->db->prepare("SELECT * FROM articles WHERE id=:id");
    $art->bindParam("id",$id);
    $art->execute();
    $args['article']= $art->fetch(\PDO::FETCH_ASSOC);
    
    $categ = $this->db->prepare("SELECT * FROM category WHERE article_id=:id");
    $categ->bindParam("id",$id);
    $categ->execute();
    $args['selectcat']= $categ->fetch(\PDO::FETCH_ASSOC);

    var_dump($args['article']);

   $categories= $this->db->prepare('SELECT * FROM categories');
   $categories->execute();
   $args['categories']= $categories;

    $this->view->render($response, 'dashboardeditarticle.twig',$args);
  }
}