<?php

namespace App\Action;

use Slim\Views\Twig;
use Psr\Log\LoggerInterface;
use Slim\Http\Request;
use Slim\Http\Response;

final class RegisterAction
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
    $data = $request->getParsedBody();
    $nom =$data['Name'];
    $prenom =
    $email=
    $sentpassword=
    $password=password_hash($sentpassword, PASSWORD_BCRYPT,['cost' => 12]);

    $user = $this->db->prepare('INSERT INTO users(nom,prenom,pseudo,email,password,inscriptiondate,permission) VALUES (:nom,:prenom,:pseudo,:email,:password,NOW(),1');
    $user->bindValue('nom', $nom, \PDO::PARAM_STR); 
    $user->bindValue('prenom', $prenom, \PDO::PARAM_STR); 
    $user->bindValue('pseudo', $pseudo, \PDO::PARAM_STR);
    $user->bindValue('email', $email, \PDO::PARAM_STR);
    $user->bindValue('password', $password, \PDO::PARAM_STR);
    $user->execute();
  }
}