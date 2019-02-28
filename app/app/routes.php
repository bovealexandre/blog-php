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



