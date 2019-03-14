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
    $data = $request->getParsedBody();
    $pseudo =$_SESSION['id'];
    $title =$data['title']; // récupérations de données, envoies dans les bindvalues
    $category=$data['category'];
    $text=$data['text'];
    $image=$data['image'];

    $article = $this->db->prepare("INSERT INTO articles(writer_id,title,text,publish_date,image) VALUES (:pseudo,:title,:text,NOW(),:image)  RETURNING id");
    $article->bindValue('pseudo', $pseudo, \PDO::PARAM_STR); 
    $article->bindValue('title', $title, \PDO::PARAM_STR); // renvoie dans les values les données que j'envoie 
    $article->bindValue('text', $text, \PDO::PARAM_STR);
    $article->bindValue('image', $image, \PDO::PARAM_STR);
    $article->execute();

    $categ = $this->db->prepare("SELECT id FROM articles  ORDER BY publish_date DESC LIMIT 1");
    $categ->execute();
    $result= $categ->fetch(\PDO::FETCH_ASSOC);

    foreach($category as $category){
      $cat= $this->db->prepare("INSERT INTO category(article_id,categories) VALUES (:article_id,:category)");
      $cat->bindValue('article_id', $result['id'] , \PDO::PARAM_INT);
      $cat->bindValue('category', $category, \PDO::PARAM_INT);
      $cat->execute();
    }

    return $response->withRedirect($this->router->pathFor('dashboardarticles'), 301); // 301 = façon dont il redirige exemple = error 404
  }
}