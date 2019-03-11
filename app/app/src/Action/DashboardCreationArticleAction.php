<?php

namespace App\Action;

use Slim\Views\Twig;
use Psr\Log\LoggerInterface;
use Slim\Http\Request;
use Slim\Http\Response;

final class DashboardCreationArticleAction
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
    $pseudo =$data['pseudo'];
    $title =$data['title']; // récupérations de données, envoies dans les bindvalues
    $category=$data['category'];
    $text=$data['text'];
    
   

    $article = $this->db->prepare("BEGIN;
    INSERT INTO articles(writer_id,text,title,publish_date) VALUES (:pseudo,:title,:category,:text,NOW());
        foreach ($category as $category){
            INSERT INTO category (article_id,categories) VALUES (LAST_INSERT_ID,:category);
        }
    COMMIT;");
    $article->bindValue('pseudo', $pseudo, \PDO::PARAM_STR); 
    $article->bindValue('title', $title, \PDO::PARAM_STR); // renvoie dans les values les données que j'envoie 
    $article->bindValue('category', $category, \PDO::PARAM_INT);
    $article->bindValue('text', $text, \PDO::PARAM_STR);
    $article->execute();

    return $response->withRedirect('/', 301); // 301 = façon dont il redirige exemple = error 404
  }
}