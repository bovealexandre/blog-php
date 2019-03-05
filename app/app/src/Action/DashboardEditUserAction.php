<?php

namespace App\Action;

use Slim\Views\Twig;
use Psr\Log\LoggerInterface;
use Slim\Http\Request;
use Slim\Http\Response;

final class DashboardEditUserAction
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
      $this->logger->info("Dashboard categories page action dispatched");
      $id = $args['id'];

      $user = $this->db->prepare('SELECT * FROM users WHERE id=:id');
      $user->bindParam("id", $id);
      $user->execute();
      $args=$user->fetch();
        
      $this->view->render($response, 'dashboardedituser.twig',$args);
    }
  }