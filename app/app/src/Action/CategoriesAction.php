<?php
namespace App\Action;

use Slim\Views\Twig;
use Psr\Log\LoggerInterface;
use Slim\Http\Request;
use Slim\Http\Response;


final class CategoriesAction
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

        $cat= $this ->db->prepare('SELECT * FROM category WHERE categories=:id');
        $cat->bindValue('id',$id);
        $cat->execute();
        $cat->fetchAll();


            $articles = $this->db->prepare('SELECT articles.*, users.pseudo FROM article LEFT JOIN users ON articles.writer_id = users.ID WHERE articles.id= :articleid');
            $articles->bindValue('id',$cat['article_id']);
            $articles->execute();
            $articles->fetchAll();
       
        $args['articles']=$articles;
        var_dump($args['articles']);
        $this->logger->info("Home page action dispatched");
        
        $this->view->render($response, 'categories.twig',$args);
    }
}
