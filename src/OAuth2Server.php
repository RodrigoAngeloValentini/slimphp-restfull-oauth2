<?php

namespace WebDevBr;

use WebDevBr\OAuth2\Server;
use WebDevBr\Storage\Client;
use WebDevBr\Storage\AccessToken;
use WebDevBr\Storage\AuthenticationToken;

class OAuth2Server
{
    public function getInstance($conn)
    {
        $server = new Server;

        $server->setClientStorage((new Client)->setDb($conn));
        $server->setAccessTokenStorage((new AccessToken)->setDb($conn));
        $server->setAuthenticationTokenStorage((new AuthenticationToken)->setDb($conn));

        return $server;
    }
}