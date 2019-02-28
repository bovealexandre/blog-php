<?php
// DIC configuration

$container = $app->getContainer();

// -----------------------------------------------------------------------------
// Service providers
// -----------------------------------------------------------------------------


// CSRF Protection

$container['csrf'] = function ($c) {
    return new \Slim\Csrf\Guard;
};

$container['session'] = function ($c) {
    return new \SlimSession\Helper;
};


// Database connection

$container['db']= function($c) {
    $settings = $c->get('settings')['db'];
    $pdo = new PDO("pgsql:host=" . $settings['host'] . ";dbname=" . $settings['database'],
        $settings['username'], $settings['password']);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
    return $pdo;
};

// Twig
$container['view'] = function ($c) {
    $settings = $c->get('settings');
    $view = new Slim\Views\Twig($settings['view']['template_path'], $settings['view']['twig']);

    // Add extensions
    $view->addExtension(new Slim\Views\TwigExtension($c->get('router'), $c->get('request')->getUri()));
    $view->addExtension(new App\Action\CsrfAction($c->get('csrf')));
    $view->addExtension(new Twig_Extension_Debug());


    $view->offsetSet('session', $_SESSION);

    return $view;
};

// Flash messages
$container['flash'] = function ($c) {
    return new Slim\Flash\Messages;
};

// -----------------------------------------------------------------------------
// Service factories
// -----------------------------------------------------------------------------

// monolog
$container['logger'] = function ($c) {
    $settings = $c->get('settings');
    $logger = new Monolog\Logger($settings['logger']['name']);
    $logger->pushProcessor(new Monolog\Processor\UidProcessor());
    $logger->pushHandler(new Monolog\Handler\StreamHandler($settings['logger']['path'], Monolog\Logger::DEBUG));
    return $logger;
};

// -----------------------------------------------------------------------------
// Action factories
// -----------------------------------------------------------------------------

$container[App\Action\HomeAction::class] = function ($c) {
    return new App\Action\HomeAction($c->get('view'), $c->get('logger'),$c->get('db'));
};

$container[App\Action\ArticleAction::class] = function ($c) {
    return new App\Action\ArticleAction($c->get('view'), $c->get('logger'),$c->get('db'));
};

$container[App\Action\ConnexionAction::class] = function ($c) {
    return new App\Action\ConnexionAction($c->get('view'), $c->get('logger'),$c->get('db'));
};

$container[App\Action\ConnectAction::class] = function ($c) {
    return new App\Action\ConnectAction($c->get('view'), $c->get('logger'),$c->get('db'));
};

$container[App\Action\DisconnectAction::class] = function ($c) {
    return new App\Action\DisconnectAction($c->get('view'), $c->get('logger'),$c->get('db'));
};

$container[App\Action\RegisterPageAction::class] = function ($c) {
    return new App\Action\RegisterPageAction($c->get('view'), $c->get('logger'),$c->get('db'));
};

$container[App\Action\RegisterAction::class] = function ($c) {
    return new App\Action\RegisterAction($c->get('view'), $c->get('logger'),$c->get('db'));
};

$container[App\Action\CreateArticleAction::class] = function ($c) {
    return new App\Action\CreateArticleAction($c->get('view'), $c->get('logger'),$c->get('db'));
};

$container[App\Action\CreateArticlePageAction::class] = function ($c) {
    return new App\Action\CreateArticlePageAction($c->get('view'), $c->get('logger'),$c->get('db'));
};