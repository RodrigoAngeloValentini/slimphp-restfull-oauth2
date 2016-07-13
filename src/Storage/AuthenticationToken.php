<?php

namespace WebDevBr\Storage;

use WebDevBr\OAuth2\Storage\StorageInterface;

class AuthenticationToken extends AccessToken implements StorageInterface
{
    protected $type=1;
}