<?php

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST, GET, PUT, DELETE");
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept, Authorization");

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use WebDevBr\Tasks;

$app->group('/api/v1/tasks', function() use($conn) {

    $this->map(['OPTIONS'], '/[{id}]', function() {
        echo '';
    });

    //todos ou vários registros
    $this->get('/', function(Request $request, Response $response) use($conn) {
        $qb = $conn->createQueryBuilder();
        $result = $qb->select('*')
            ->from('tasks')
            ->execute()
            ->fetchAll();

        $response = $response->withHeader('Content-Type', 'application/json');
        $response->getBody()->write(json_encode($result));
        return $response;
    });

    //apenas um registro
    $this->get('/{id:[0-9]}', function(Request $request, Response $response, $args) use($conn) {
        $qb = $conn->createQueryBuilder();
        $result = (new Tasks($qb))->fetch($args['id']);

        if (!$result) {
            return $response->withStatus(404);
        }

        $response = $response->withHeader('Content-Type', 'application/json');
        $response->getBody()->write(json_encode($result));
        return $response;
    });

    //insere um registro
    $this->post('/', function(Request $request, Response $response) use($conn) {
        $data = $request->getParsedBody();

        $qb = $conn->createQueryBuilder();

        $tasks = new Tasks($qb);
        $tasks->validate($data);

        $qb->insert('tasks')
            ->values([
                'title'=>'?',
                'description'=>'?',
                'datetime'=>'?',
                'checked'=>'?',
            ])
            ->setParameter(0, $data['title'])
            ->setParameter(1, $data['description'])
            ->setParameter(2, $data['datetime'])
            ->setParameter(3, 0);

        $qb->execute();

        return '{status:"ok"}';
    });

    //atualizar um registro
    $this->put('/{id:[0-9]}', function(Request $request, Response $response, $args) use($conn) {

        $qb = $conn->createQueryBuilder();

        $tasks = new Tasks($qb);
        $result = $tasks->fetch($args['id']);

        if (!$result) {
            return $response->withStatus(404);
        }

        $data = $request->getParsedBody();
        $tasks->validate($data);

        $qb->update('tasks')
            ->set('title', '?')
            ->set('description', '?')
            ->set('datetime', '?')
            ->set('checked', '?')
            ->where('id=?')
            ->setParameter(0, $data['title'])
            ->setParameter(1, $data['description'])
            ->setParameter(2, $data['datetime'])
            ->setParameter(3, $data['checked'])
            ->setParameter(4, $args['id'])
            ->execute();

        return '{status:"ok"}';
    });

    //remover um registro
    $this->delete('/{id:[0-9]}', function(Request $request, Response $response, $args) use($conn) {
        $qb = $conn->createQueryBuilder();
        $result = (new Tasks($qb))->fetch($args['id']);

        if (!$result) {
            return $response->withStatus(404);
        }

        $result = $qb->delete('tasks')
            ->where('id='.$args['id'])
            ->execute();

        echo '{method:"delete",id:'.$args['id'].'}';
    });
});
