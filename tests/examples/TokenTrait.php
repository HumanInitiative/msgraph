<?php

namespace tests\examples;

use humaninitiative\graph\AccessToken;

trait TokenTrait
{
    public function getToken()
    {
        // TODO: add cache

        $accessToken = new AccessToken(
            getenv('TENANT_ID'),
            getenv('CLIENT_ID'),
            getenv('CLIENT_SECRET')
        );

        return $accessToken->generate();
    }
}
