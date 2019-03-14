<?php

namespace App\Action;

use Slim\Views\Twig;
use Psr\Log\LoggerInterface;
use Slim\Http\Request;
use Slim\Http\Response;

final class DashboardUpdateArticleAction
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
    $data = $request->getParsedBody();
    $pseudo =$_SESSION['id'];
    $title =$data['title']; // récupérations de données, envoies dans les bindvalues
    $category=$data['category'];
    $text=$data['text'];

    $article = $this->db->prepare("UPDATE articles SET title=:title,text=:text WHERE id=:id");
    $article->bindValue('id', $id);
    $article->bindValue('title', $title, \PDO::PARAM_STR); // renvoie dans les values les données que j'envoie 
    $article->bindValue('text', $text, \PDO::PARAM_STR);
    $article->execute();

    $del=$this->db->prepare("DELETE FROM category WHERE article_id=:id");
    $del->bindValue('id',$id);
    $del->execute();

    foreach($category as $category){
      $cat= $this->db->prepare("INSERT INTO category(article_id,categories) VALUES (:article_id,:category)");
      $cat->bindValue('article_id', $id , \PDO::PARAM_INT);
      $cat->bindValue('category', $category, \PDO::PARAM_INT);
      $cat->execute();
    }

    return $response->withRedirect('/~alex/app/public/dashboard/articles', 301); // 301 = façon dont il redirige exemple = error 404
  }
}