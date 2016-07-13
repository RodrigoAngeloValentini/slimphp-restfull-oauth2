<?php

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST, GET, PUT, DELETE");
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept, Authorization");

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use WebDevBr\Tasks;
use WebDevBr\OAuth2Server;
use WebDevBr\Storage\AccessToken;
use WebDevBr\OAuth2\Token;

$app->group('/api/v1/users', function() use($conn) {

    $server = (new OAuth2Server)->getInstance($conn);

    //autenticação da app cliente
    $this->get('/client', function(Request $request, Response $response) use ($server){
        $token = new \stdClass;
        try{
            $token->authorization = $server->clientAuthorization();
        } catch(\Exception $e) {
            echo $e->getMessage();
            die;
        }

        $response = $response->withHeader('Content-Type', 'application-json');
        return $response->getBody()->write(json_encode($token));
    });

    //autenticação do usuário
    $this->post('/oauth', function(Request $request, Response $response) use($server, $conn){
        $token = new \stdClass;

        $email = filter_input(INPUT_POST, 'username');
        $password = filter_input(INPUT_POST, 'password');

        $qb = $conn->createQueryBuilder();
        $result = $qb->select('*')
            ->from('users')
            ->where('email=?')
            ->setParameter(0, $email)
            ->execute()
            ->fetch();

        if (!empty($user) and $password != $user['password']) {
            return $response->withStatus(401);
        }

        try{
            $token->authorization = $server->accessAuthorization();
        } catch(\Exception $e) {
            echo $e->getMessage();
            die;
        }
        $response = $response->withHeader('Content-Type', 'application-json');
        return $response->getBody()->write(json_encode($token));
    });

    //autenticação da app cliente e usuário
    $this->post('/oauth-full', function(Request $request, Response $response) use($server, $conn){

        //autentica cliente
        $token = new \stdClass;
        try{
            $token->authorization = $server->clientAuthorization();
        } catch(\Exception $e) {
            echo $e->getMessage();
            die;
        }

        //autentica usuario

        $token = new \stdClass;

        $email = filter_input(INPUT_POST, 'username');
        $password = filter_input(INPUT_POST, 'password');

        $qb = $conn->createQueryBuilder();
        $result = $qb->select('*')
            ->from('users')
            ->where('email=?')
            ->setParameter(0, $email)
            ->execute()
            ->fetch();

        if (!$result or $password != $result['password']) {
            return $response->withStatus(401);
        }

        try{
            $access_token = (new AccessToken)->setDb($conn);
            $token->authorization = (new Token)->generate($access_token);
        } catch(\Exception $e) {
            echo $e->getMessage();
            die;
        }

        $response = $response->withHeader('Content-Type', 'application-json');
        return $response->getBody()->write(json_encode($token));
    });

    //todos ou vários registros
    $this->get('/', function(Request $request, Response $response) use($conn) {
        $qb = $conn->createQueryBuilder();
        $result = $qb->select('*')
            ->from('users')
            ->execute()
            ->fetchAll();

        $response = $response->withHeader('Content-Type', 'application/json');
        $response->getBody()->write(json_encode($result));
        return $response;

    })
        ->add(function($request, $response, $next) use($server) {
            try{
                if ($server->requestIsValid()) {
                    return $next($request, $response);
                }
            } catch(\Exception $e) {
                echo $e->getMessage();
                die;
            }

            $response = new \Slim\Http\Response;
            return $response->withStatus(401);
        });
});
