<?php

namespace Dougl\Projetoweb\Controllers;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Dougl\Projetoweb\Auth\JWTAuth;
use Illuminate\Database\Capsule\Manager as DB;

class AuthController
{
    private $jwtAuth;

    public function __construct()
    {
        $this->jwtAuth = new JWTAuth();
    }

    public function login(Request $request, Response $response)
    {
        $data = json_decode($request->getBody()->getContents(), true);

        if (!isset($data['registration']) || !isset($data['email'])) {
            $response->getBody()->write(json_encode(['error' => 'Matrícula e email são obrigatórios']));
            return $response->withHeader('Content-Type', 'application/json')->withStatus(400);
        }

        $student = DB::table('students')
            ->where('registration', $data['registration'])
            ->where('email', $data['email'])
            ->first();

        if (!$student) {
            $response->getBody()->write(json_encode(['error' => 'Credenciais inválidas']));
            return $response->withHeader('Content-Type', 'application/json')->withStatus(401);
        }

        $token = $this->jwtAuth->generateToken([
            'sub' => $student->id,
            'registration' => $student->registration,
            'email' => $student->email
        ]);

        $response->getBody()->write(json_encode(['token' => $token]));
        return $response->withHeader('Content-Type', 'application/json');
    }
}