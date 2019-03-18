<?php
namespace App\Action;

use Slim\Views\Twig;
use Psr\Log\LoggerInterface;
use Slim\Http\Request;
use Slim\Http\Response;


final class HomeAction
{
    private $view;
    private $logger;
    private $db;

    public function __construct(Twig $view, LoggerInterface $logger, $db)
    {
        $this->view = $view;
        $this->logger = $logger;
        $this->db=$db;
    }

    public function __invoke(Request $request, Response $response, $args)
    {
        $articles = $this->db->prepare('SELECT articles.*, users.pseudo FROM articles LEFT JOIN users ON articles.writer_id = users.ID ORDER BY publish_date DESC LIMIT 5');
        $articles->execute();

        $categories= $this->db->prepare('SELECT * FROM categories');
        $categories->execute();

        $args['categories']=$categories;
        $args['articles']=$articles;
        $this->logger->info("Home page action dispatched");
        
        $this->view->render($response, 'home.twig',$args);
    }
}
