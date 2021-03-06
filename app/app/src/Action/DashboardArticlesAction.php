<?php

namespace App\Action;

use Slim\Views\Twig;
use Psr\Log\LoggerInterface;
use Slim\Http\Request;
use Slim\Http\Response;

final class DashboardArticlesAction
{
    private $view;
    private $logger;
    private $db;

    public function __construct(Twig $view, LoggerInterface $logger, $db)
    {
        $this->view = $view;
        $this->logger = $logger;
        $this->db = $db;
    }

    public function __invoke(Request $request, Response $response, $args)
    {
      $this->logger->info("Dashboard user page action dispatched");
      if ($_SESSION['permission'] !== 2){
      $articles = $this->db->prepare('SELECT articles.*, users.pseudo FROM articles LEFT JOIN users ON articles.writer_id = users.ID');
      $articles->execute();

      }else{
        $articles = $this->db->prepare('SELECT articles.*, users.pseudo FROM articles LEFT JOIN users ON articles.writer_id = users.ID WHERE articles.writer_id = :id');
        $articles->bindValue('id',$_SESSION['id']);
        $articles->execute();
      }
      $args['articles']=$articles;
      $this->view->render($response, 'dashboardarticles.twig',$args);
    }
  }