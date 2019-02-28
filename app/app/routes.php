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

    $app->get('/registerAction', App\Action\RegisterAction::class)
    ->setName('registerAction');