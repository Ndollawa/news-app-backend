<?php

namespace App\Http\Middleware;

use Illuminate\Http\Middleware\TrustProxies as Middleware;
use Illuminate\Http\Request;

class TrustProxies extends Middleware
{
    /**
     * The trusted proxies for this application.
     *
     * @var array<int, string>|string|null
     */
    protected $proxies;

    /**
     * The headers that should be used to detect proxies.
     *
     * @var int
     */

        /**
     * The trusted proxies for this application.
     *
     * @var array|string|null
     */
    protected $headers = [
        Request::HEADER_X_FORWARDED_FOR |
        Request::HEADER_X_FORWARDED_HOST |
        Request::HEADER_X_FORWARDED_PORT |
        Request::HEADER_X_FORWARDED_PROTO |
        Request::HEADER_X_FORWARDED_AWS_ELB,
        Request::HEADER_X_FORWARDED_PROTO => 'https', // Set the 'X-Forwarded-Proto' header to 'https'
        // Request::HEADER_HTTP_ONLY => true, // Set the 'HttpOnly' flag
        // Request::HEADER_SECURE => true, // Set the 'Secure' flag
    ];

}
