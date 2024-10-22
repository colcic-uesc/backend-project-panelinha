<?php

namespace Dougl\Projetoweb\Middleware;

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Server\RequestHandlerInterface as RequestHandler;
use Slim\Psr7\Response;

class HeadersMiddleware
{
    public function __invoke(Request $request, RequestHandler $handler): Response
    {
        $response = $handler->handle($request);
        
        return $response
            ->withHeader('X-APP-NAME', 'Panelinha')
            ->withHeader('X-APP-API-VERSION', '0.1');
    }
}