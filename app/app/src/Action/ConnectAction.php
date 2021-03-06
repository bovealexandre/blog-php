<?php

namespace App\Action;


$router = $app->router;

use Slim\Views\Twig;
use Slim\Router;
use Psr\Log\LoggerInterface;
use Slim\Http\Request;
use Slim\Http\Response;

final class ConnectAction
{
    private $view;
    private $logger;
    private $db;
    private $router;

    public function __construct(Twig $view, LoggerInterface $logger,$db, Router $router)
    {
        $this->view = $view;
        $this->logger = $logger;
        $this->db=$db;
        $this->router = $router;
    }

    public function __invoke(Request $request, Response $response, $args)
    {
        $data = $request->getParsedBody();
        $pseudo=filter_var($data['pseudo'], FILTER_SANITIZE_STRING);
        $password= password_hash($data['password'], PASSWORD_BCRYPT,['cost' => 12]);
        $this->logger->info("Connect action dispatched");
        $user = $this->db->prepare('SELECT * FROM users WHERE pseudo =:pseudo OR email=:pseudo');
        $user->bindValue('pseudo', $pseudo, \PDO::PARAM_STR);
        $user->execute();
        $user= $user->fetch(\PDO::FETCH_ASSOC);
        if ($pseudo === $user['pseudo'] || $pseudo === $user['email']){
          $_SESSION['login'] = true;
          $_SESSION['id']=$user['id'];
          $_SESSION['name']=$user['prenom'];
          $_SESSION["pseudo"]=$user["pseudo"];
          $_SESSION["permission"]= $user["permission"];

          return $response->withRedirect($this->router->pathFor('home'), 301);


        }else{
          return $response->withRedirect($this->router->pathFor('connexion'), 301);
        }
        return $response;
    }
}