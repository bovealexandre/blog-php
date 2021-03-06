<?php
namespace App\Action;

use Slim\Views\Twig;
use Psr\Log\LoggerInterface;
use Slim\Http\Request;
use Slim\Http\Response;


final class AuthorAction
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
        $id=$args["id"];

        $categories= $this->db->prepare('SELECT * FROM categories');
        $categories->execute();


            $articles = $this->db->prepare('SELECT  category.*, articles.*, users.pseudo FROM category INNER JOIN articles ON category.article_id=articles.id INNER JOIN users ON articles.writer_id = users.ID WHERE users.id= :id');
            $articles->bindValue('id',$args['id']);
            $articles->execute();
       
            $args['categories']=$categories;
        $args['articles']=$articles;
        $this->logger->info("Home page action dispatched");
        
        $this->view->render($response, 'auteurs.twig',$args);
    }
}