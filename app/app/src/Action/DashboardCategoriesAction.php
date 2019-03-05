<?php

namespace App\Action;

use Slim\Views\Twig;
use Psr\Log\LoggerInterface;
use Slim\Http\Request;
use Slim\Http\Response;

final class DashboardCategoriesAction
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

      $categories = $this->db->prepare('SELECT * FROM categories');
      $categories->execute();
      $args['categories']=$categories;
        
      $this->view->render($response, 'dashboardcategories.twig',$args);
    }
  }