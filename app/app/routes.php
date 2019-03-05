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

$app->get('/dashboard/edit/user/{id}', App\Action\DashboardEditUserAction::class)
    ->setName('dashboardedituser');

$app->post('/dashboard/update/user/{id}', App\Action\DashboardUpdateUserAction::class)
    ->setName('dashboardupdateuser');

$app->get('/dashboard/delete/user/{id}', App\Action\DashboardDeleteUserAction::class)
    ->setName('dashboarddeleteuser');

$app->get('/dashboard/articles', App\Action\DashboardArticlesAction::class)
    ->setName('dashboardarticles');

$app->get('/dashboard/create/article', App\Action\DashboardCreateArticleAction::class)
    ->setName('dashboardcreatearticle');

$app->get('/dashboard/categories', App\Action\DashboardCategoriesAction::class)
    ->setName('dashboardcategories');

$app->get('/dashboard/create/category', App\Action\DashboardCreateCategoryAction::class)
    ->setName('dashboardcreatecategory');

$app->post('/dashboard/create/new/category', App\Action\CreateCategoryAction::class)
    ->setName('dashboardcreatenewcategory');

$app->get('/dashboard/edit/category/{id}', App\Action\DashboardEditCategoryAction::class)
    ->setName('dashboardeditcategory');

$app->post('/dashboard/update/category/{id}', App\Action\DashboardUpdateCategoryAction::class)
    ->setName('dashboardupdatecategory');

$app->get('/dashboard/delete/category/{id}', App\Action\DashboardDeleteCategoryAction::class)
    ->setName('dashboarddeletecategory');