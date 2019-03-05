<?php

namespace App\Action;

use Slim\Views\Twig;
use Psr\Log\LoggerInterface;
use Slim\Http\Request;
use Slim\Http\Response;

final class DashboardUserAction
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

      $users = $this->db->prepare('SELECT * FROM users');
      $users->execute();
      $args['users']=$users;
        
      $this->view->render($response, 'dashboarduser.twig',$args);
    }
  }