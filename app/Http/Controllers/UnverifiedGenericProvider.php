<?php

namespace App\Http\Controllers;

use \League\OAuth2\Client\Provider\GenericProvider;

class UnverifiedGenericProvider extends GenericProvider
{
    //
    protected function getAllowedClientOptions( array $options ) {
        return [ 'timeout', 'proxy', 'verify', ];

	}
}
