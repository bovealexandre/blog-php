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


// upload images

$container['upload_directory'] = __DIR__ . '/uploads';


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

$container[App\Action\DashboardHomeAction::class] = function ($c) {
    return new App\Action\DashboardHomeAction($c->get('view'), $c->get('logger'),$c->get('db'));
};

$container[App\Action\DashboardUserAction::class] = function ($c) {
    return new App\Action\DashboardUserAction($c->get('view'), $c->get('logger'),$c->get('db'));
};

$container[App\Action\DashboardEditUserAction::class] = function ($c) {
    return new App\Action\DashboardEditUserAction($c->get('view'), $c->get('logger'),$c->get('db'));
};

$container[App\Action\DashboardUpdateUserAction::class] = function ($c) {
    return new App\Action\DashboardUpdateUserAction($c->get('view'), $c->get('logger'),$c->get('db'));
};

$container[App\Action\DashboardDeleteUserAction::class] = function ($c) {
    return new App\Action\DashboardDeleteUserAction($c->get('view'), $c->get('logger'),$c->get('db'));
};

$container[App\Action\DashboardArticlesAction::class] = function ($c) {
    return new App\Action\DashboardArticlesAction($c->get('view'), $c->get('logger'),$c->get('db'));
};

$container[App\Action\DashboardCreateArticleAction::class] = function ($c) {
    return new App\Action\DashboardCreateArticleAction($c->get('view'), $c->get('logger'),$c->get('db'));
};

$container[App\Action\DashboardCategoriesAction::class] = function ($c) {
    return new App\Action\DashboardCategoriesAction($c->get('view'), $c->get('logger'),$c->get('db'));
};

$container[App\Action\DashboardCreateCategoryAction::class] = function ($c) {
    return new App\Action\DashboardCreateCategoryAction($c->get('view'), $c->get('logger'),$c->get('db'));
};

$container[App\Action\CreateCategoryAction::class] = function ($c) {
    return new App\Action\CreateCategoryAction($c->get('view'), $c->get('logger'),$c->get('db'));
};

$container[App\Action\DashboardEditCategoryAction::class] = function ($c) {
    return new App\Action\DashboardEditCategoryAction($c->get('view'), $c->get('logger'),$c->get('db'));
};

$container[App\Action\DashboardUpdateCategoryAction::class] = function ($c) {
    return new App\Action\DashboardUpdateCategoryAction($c->get('view'), $c->get('logger'),$c->get('db'));
};

$container[App\Action\DashboardDeleteCategoryAction::class] = function ($c) {
    return new App\Action\DashboardDeleteCategoryAction($c->get('view'), $c->get('logger'),$c->get('db'));
};

$container[App\Action\DashboardCreationArticleAction::class] = function ($c) {
    return new App\Action\DashboardCreationArticleAction($c->get('view'), $c->get('logger'),$c->get('db'));
};

$container[App\Action\DashboardEditArticleAction::class] = function ($c) {
    return new App\Action\DashboardEditArticleAction($c->get('view'), $c->get('logger'),$c->get('db'));
};

$container[App\Action\DashboardUpdateArticleAction::class] = function ($c) {
    return new App\Action\DashboardUpdateArticleAction($c->get('view'), $c->get('logger'),$c->get('db'));
};

$container[App\Action\DashboardDeleteArticleAction::class] = function ($c) {
    return new App\Action\DashboardDeleteArticleAction($c->get('view'), $c->get('logger'),$c->get('db'));
};