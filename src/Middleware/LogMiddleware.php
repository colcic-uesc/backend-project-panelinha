<?php

namespace Dougl\Projetoweb\Middleware;

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Server\RequestHandlerInterface as RequestHandler;
use Slim\Psr7\Response;

class LogMiddleware
{
    public function __invoke(Request $request, RequestHandler $handler): Response
    {
        $startTime = microtime(true);
        
        $response = $handler->handle($request);
        
        $endTime = microtime(true);
        $processingTime = ($endTime - $startTime) * 1000; // em millisegundos

        $ip = $request->getServerParams()['REMOTE_ADDR'] ?? 'unknown';
        $hasJwt = !empty($request->getHeaderLine('Authorization')) ? 'Sim' : 'Não';
        $datetime = date('Y-m-d H:i:s');
        $method = $request->getMethod();
        $url = (string) $request->getUri();
        $processingTimeFormatted = round($processingTime, 2) . 'ms';

        $logMessage = sprintf(
            "IP: %s | JWT: %s | Data/Hora: %s | Método: %s | URL: %s | Tempo de processamento: %s\n",
            $ip,
            $hasJwt,
            $datetime,
            $method,
            $url,
            $processingTimeFormatted
        );

        file_put_contents(__DIR__ . '/../../logs/api.log', $logMessage, FILE_APPEND);

        return $response;
    }
}