<?php
namespace App\Middlewares;

use Slim\Http\Request;
use Slim\Http\Response;

class AuthMiddleware {

  private $container;

  public function __construct($container) {
    $this->container = $container;
  }

  public function __invoke(Request $request, Response $response, $next) {
    $id=$next['id'];
    var_dump($id);
    $artid= $this->container->get('db')->prepare('SELECT writer_id FROM articles WHERE id=:id');
    $artid->bindValue('id', $id);
    $artid->execute();
    $writerid = $artid->fetch(\PDO::FETCH_ASSOC);
    if (!isset($_SESSION['permission']) || empty($_SESSION['permission'])) {
      //return $response->withRedirect($this->container->router->pathFor('connexion'));
    }elseif($_SESSION['permission']=== 1 || $_SESSION['permission']=== 2 || $_SESSION['id'] !== $id || $_SESSION['id'] !== $writerid  ){
      //return $response->withRedirect($this->container->router->pathFor('dashboard'));
    }
    $response = $next($request, $response);
    //return $response;
  }
}