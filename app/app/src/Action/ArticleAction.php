<?php
namespace App\Action;

use Slim\Views\Twig;
use Psr\Log\LoggerInterface;
use Slim\Http\Request;
use Slim\Http\Response;

final class ArticleAction
{
    private $view;
    private $logger;
    private $db;

    public function __construct(Twig $view, LoggerInterface $logger,$db)
    {

        $this->db=$db;
        $this->view = $view;
        $this->logger = $logger;
    }

    public function __invoke(Request $request, Response $response, $args)
    {
        $id=$args['id'];
        $articles = $this->db->prepare('SELECT articles.*, users.pseudo FROM articles INNER JOIN users ON articles.writer_id = users.ID WHERE articles.id= :articleid');
        $articles->bindValue('articleid',$id);
        $articles->execute();
        $args['article']=$articles->fetch(\PDO::FETCH_ASSOC);
        $this->logger->info("Article page action dispatched");

        $categories= $this->db->prepare('SELECT * FROM categories');
        $categories->execute();

        $comments= $this->db->prepare('SELECT comments.*, users.pseudo, users.id FROM comments INNER JOIN users ON comments.writer_id = users.id WHERE article_id=:id');
        $comments->bindValue('id',$id);
        $comments->execute();

        $args['categories']=$categories;
        $args['comments']=$comments;
        
        $this->view->render($response, 'article.twig',$args);
        return $response;
    }
}
