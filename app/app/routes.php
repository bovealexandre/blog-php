<?php
// Routes

$app->get('/', App\Action\HomeAction::class)
    ->setName('home');

$app->get('/article', App\Action\ArticleAction::class)
    ->setName('article');

$app->get('/connexion', App\Action\ConnexionAction::class)
    ->setName('connexion');

$app->post('/connect', App\Action\ConnectAction::class)
    ->setName('connect');

$app->get('/disconnect', App\Action\DisconnectAction::class)
    ->setName('disconnect');

$app->get('/register', App\Action\RegisterPageAction::class)
    ->setName('register');

$app->post('/registerAction', App\Action\RegisterAction::class)
    ->setName('registerAction');

$app->post('/createarticleAction', App\Action\CreateArticleAction::class)
    ->setName('CreateArticleAction');

$app->get('/createarticle', App\Action\CreateArticlePageAction::class)
    ->setName('createarticle');

$app->get('/dashboard', App\Action\DashboardHomeAction::class)
    ->setName('dashboard')->add(new App\Middlewares\SessionMiddleware($container));

$app->get('/dashboard/users', App\Action\DashboardUserAction::class)
    ->setName('dashboarduser')->add(new App\Middlewares\SessionMiddleware($container));

$app->get('/dashboard/edit/user/{id}', App\Action\DashboardEditUserAction::class)
    ->setName('dashboardedituser')->add(new App\Middlewares\SessionMiddleware($container));

$app->post('/dashboard/update/user/{id}', App\Action\DashboardUpdateUserAction::class)
    ->setName('dashboardupdateuser')->add(new App\Middlewares\SessionMiddleware($container));

$app->get('/dashboard/delete/user/{id}', App\Action\DashboardDeleteUserAction::class)
    ->setName('dashboarddeleteuser')->add(new App\Middlewares\SessionMiddleware($container));

$app->get('/dashboard/articles', App\Action\DashboardArticlesAction::class)
    ->setName('dashboardarticles')->add(new App\Middlewares\SessionMiddleware($container));

$app->get('/dashboard/create/article', App\Action\DashboardCreateArticleAction::class)
    ->setName('dashboardcreatearticle')->add(new App\Middlewares\SessionMiddleware($container));

$app->get('/dashboard/categories', App\Action\DashboardCategoriesAction::class)
    ->setName('dashboardcategories')->add(new App\Middlewares\SessionMiddleware($container));

$app->get('/dashboard/create/category', App\Action\DashboardCreateCategoryAction::class)
    ->setName('dashboardcreatecategory')->add(new App\Middlewares\SessionMiddleware($container));

$app->post('/dashboard/create/new/category', App\Action\CreateCategoryAction::class)
    ->setName('dashboardcreatenewcategory')->add(new App\Middlewares\SessionMiddleware($container));

$app->get('/dashboard/edit/category/{id}', App\Action\DashboardEditCategoryAction::class)
    ->setName('dashboardeditcategory')->add(new App\Middlewares\SessionMiddleware($container));

$app->post('/dashboard/update/category/{id}', App\Action\DashboardUpdateCategoryAction::class)
    ->setName('dashboardupdatecategory')->add(new App\Middlewares\SessionMiddleware($container));

$app->get('/dashboard/delete/category/{id}', App\Action\DashboardDeleteCategoryAction::class)
    ->setName('dashboarddeletecategory')->add(new App\Middlewares\SessionMiddleware($container));