<?php

namespace App\Action;

use Slim\Views\Twig;
use Psr\Log\LoggerInterface;
use Slim\Http\Request;
use Slim\Http\Response;

final class CreateArticleAction
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
    $title =$data['title'];
    $image =$data['image'];
    $text =$data['text'];

    $id=$this->db->prepare('SELECT id FROM users WHERE pseudo = :pseudo');
    $id->bindValue('pseudo',$_SESSION['pseudo'],\PDO::PARAM_STR);
    $id->execute();
    $result= $id->fetch(\PDO::FETCH_ASSOC);


    $articles = $this->db->prepare('INSERT INTO articles(text,title,image,writer_id,publish_date) VALUES (:text,:title,:image,:writer_id,NOW())');
    $articles->bindValue('title', $title, \PDO::PARAM_STR); 
    $articles->bindValue('image', $image, \PDO::PARAM_STR); // renvoie dans les values les données que j'envoie 
    $articles->bindValue('text', $text, \PDO::PARAM_STR);
    $articles->bindValue('writer_id', $result['id'], \PDO::PARAM_INT);
    $articles->execute();

    return $response->withRedirect('/', 301);


  }
 }