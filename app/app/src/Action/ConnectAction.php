<?php

namespace App\Action;

use Slim\Views\Twig;
use Psr\Log\LoggerInterface;
use Slim\Http\Request;
use Slim\Http\Response;

final class ConnectAction
{
    private $view;
    private $logger;
    private $db;
    private $container;

    public function __construct($container)
    {
        $this->view = $container->$view;
        $this->logger = $container->$logger;
        $this->db=$container->$db;
        $this->container = $container;
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


          return $response->withRedirect($this->container->router->pathFor('home'), 301);


        }else{
          return $response->withRedirect('/~alex/app/public/connexion', 301);
        }
        return $response;
    }
}