<?php

include __DIR__.'/vendor/autoload.php';

use Doctrine\DBAL\Configuration;
use Doctrine\DBAL\DriverManager;
use Symfony\Component\Yaml\Parser;
use WebDevBr\Config;

$parser = new Parser;
Config::set($parser->parse(file_get_contents(__DIR__.'/phinx.yml'))['environments']);

$config = Config::get('development');

$connectionParams = [
    'dbname'=>$config['name'],
    'user'=>$config['user'],
    'password'=>$config['pass'],
    'host'=>$config['host'],
    'driver'=>'pdo_mysql',
];

$conn = DriverManager::getConnection($connectionParams, new Configuration);

//$qb = $conn->createQueryBuilder();
//$result = $qb->select('*')
//		->from('users')
//		->execute()
//		->fetch();
//
//var_dump($result);

include __DIR__.'/app.php';