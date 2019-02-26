<?php
// Routes

$app->get('/', App\Action\HomeAction::class)
    ->setName('home');

$app->get('/article', App\Action\ArticleAction::class)
    ->setName('article');
