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
    if (!isset($_SESSION['permission']) || empty($_SESSION['permission'])) {
      return $response->withRedirect($this->container->router->pathFor('connexion'));
    }elseif($_SESSION['permission']=== 1 || $_SESSION['permission']=== 2){
      return $response->withRedirect($this->container->router->pathFor('dashboard'));
    }
    $response = $next($request, $response);
    return $response;
  }
}