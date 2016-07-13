<?php

use Slim\App;
use Slim\Container;

$app = new App(new Container);

$app->get('/', function(){
    echo 'Hello World';
});

include __DIR__.'/modules/tasks.php';
//include __DIR__.'/modules/users.php';

$app->run();