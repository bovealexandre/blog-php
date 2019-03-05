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
    ->setName('dashboard');

$app->get('/dashboard/users', App\Action\DashboardUserAction::class)
    ->setName('dashboarduser');

$app->get('/dashboard/articles', App\Action\DashboardArticlesAction::class)
    ->setName('dashboardarticles');

$app->get('/dashboard/categories', App\Action\DashboardCategoriesAction::class)
    ->setName('dashboardcategories');

$app->get('/dashboard/edit/user/{id}', App\Action\DashboardEditUserAction::class)
    ->setName('dashboardedituser');

$app->post('/dashboard/update/user/{id}', App\Action\DashboardUpdateUserAction::class)
    ->setName('dashboardupdateuser');

$app->get('/dashboard/delete/user/{id}', App\Action\DashboardDeleteUserAction::class)
    ->setName('dashboarddeleteuser');