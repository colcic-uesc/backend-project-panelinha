<?php

namespace Dougl\Projetoweb\Middleware;

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Server\RequestHandlerInterface as RequestHandler;
use Slim\Psr7\Response;
use Dougl\Projetoweb\Auth\JWTAuth;

class JWTAuthMiddleware
{
    private $jwtAuth;

    public function __construct()
    {
        $this->jwtAuth = new JWTAuth();
    }

    public function __invoke(Request $request, RequestHandler $handler): Response
    {
        $response = new Response();
        $authorization = $request->getHeaderLine('Authorization');

        if (empty($authorization)) {
            $response->getBody()->write(json_encode(['error' => 'Token não fornecido']));
            return $response->withHeader('Content-Type', 'application/json')->withStatus(401);
        }

        $token = str_replace('Bearer ', '', $authorization);
        $payload = $this->jwtAuth->validateToken($token);

        if (!$payload) {
            $response->getBody()->write(json_encode(['error' => 'Token inválido']));
            return $response->withHeader('Content-Type', 'application/json')->withStatus(401);
        }

        $request = $request->withAttribute('jwt_payload', $payload);
        return $handler->handle($request);
    }
}