<?php

namespace App\Action;

use Slim\Views\Twig;
use Psr\Log\LoggerInterface;
use Slim\Http\Request;
use Slim\Http\Response;

final class DashboardUpdateUserAction
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
      $id = $args['id'];
      $pseudo = $request->getParsedBody()['pseudo']; //checks _POST [IS PSR-7 compliant]
      $nom = $request->getParsedBody()['name']; //checks _POST [IS PSR-7 compliant]
      $prenom = $request->getParsedBody()['firstname']; //checks _POST [IS PSR-7 compliant]
      $email = $request->getParsedBody()['email']; //checks _POST [IS PSR-7 compliant]
      $permission = $request->getParsedBody()['permission']; //checks _POST [IS PSR-7 compliant]

      $user = $this->db->prepare('UPDATE users SET pseudo=:pseudo, nom=:nom, prenom=:prenom, email=:email, permission=:permission WHERE id=:id');
      $user->bindParam("id", $id);
      $user->bindValue('pseudo', $pseudo,  \PDO::PARAM_STR);
      $user->bindValue('nom', $nom,  \PDO::PARAM_STR);
      $user->bindValue('prenom', $prenom,  \PDO::PARAM_STR);
      $user->bindValue('email', $email,  \PDO::PARAM_STR);
      $user->bindValue('permission', $permission,  \PDO::PARAM_INT);
      $user->execute();
        
      return $response->withRedirect('/dashboard/users', 301);
    }
  }