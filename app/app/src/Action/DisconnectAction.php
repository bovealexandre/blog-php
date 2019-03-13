<?php

namespace App\Action;

use Slim\Views\Twig;
use Psr\Log\LoggerInterface;
use Slim\Http\Request;
use Slim\Http\Response;

final class DisconnectAction
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
      $_SESSION['login']=false;
      unset($_SESSION['pseudo']);
      unset($_SESSION['name']);
      unset($_SESSION["permission"]);
      return $response->withRedirect('/~alex/app/public/', 301);
    }
}