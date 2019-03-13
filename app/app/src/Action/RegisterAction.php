<?php

namespace App\Action;

use Slim\Views\Twig;
use Slim\Router;
use Psr\Log\LoggerInterface;
use Slim\Http\Request;
use Slim\Http\Response;

final class RegisterAction
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
    $nom =$data['Name'];
    $prenom =$data['Firstname']; // récupérations de données, envoies dans les bindvalues
    $email=$data['user_email'];
    $pseudo=$data['pseudo'];
    $sentpassword=$data['password'];
    $password=password_hash($sentpassword, PASSWORD_BCRYPT,['cost' => 12]); // cryptage du mot de passe 

    $user = $this->db->prepare('INSERT INTO users(nom,prenom,pseudo,email,password,inscriptiondate,permission) VALUES (:nom,:prenom,:pseudo,:email,:password,NOW(),1)');
    $user->bindValue('nom', $nom, \PDO::PARAM_STR); 
    $user->bindValue('prenom', $prenom, \PDO::PARAM_STR); // renvoie dans les values les données que j'envoie 
    $user->bindValue('pseudo', $pseudo, \PDO::PARAM_STR);
    $user->bindValue('email', $email, \PDO::PARAM_STR);
    $user->bindValue('password', $password, \PDO::PARAM_STR);
    $user->execute();

    return $response->withRedirect($this->router->pathFor('home'), 301); // 301 = façon dont il redirige exemple = error 404
  }
}