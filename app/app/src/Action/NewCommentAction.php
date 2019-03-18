<?php

namespace App\Action;

use Slim\Views\Twig;
use Slim\Router;
use Psr\Log\LoggerInterface;
use Slim\Http\Request;
use Slim\Http\Response;

final class NewCommentAction
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
    $articleid =$data['articleid']; // récupérations de données, envoies dans les bindvalues
    $comment=$data['comment'];

    $article = $this->db->prepare("INSERT INTO comments(writer_id,text,publish_date,article_id) VALUES (:pseudo,:text,NOW(),:articleid)");
    $article->bindValue('pseudo', $pseudo, \PDO::PARAM_INT);  
    $article->bindValue('text', $comment, \PDO::PARAM_STR);
    $article->bindValue('articleid', $articleid, \PDO::PARAM_STR);
    $article->execute();

    return $response->withRedirect($this->router->pathFor('article', ['id' => $articleid] ), 301); // 301 = façon dont il redirige exemple = error 404
  }
}