<?php

namespace Dougl\Projetoweb\Auth;

use Firebase\JWT\JWT;
use Firebase\JWT\Key;

class JWTAuth
{
    private string $key;

    public function __construct()
    {
        $this->key = $_ENV['JWT_SECRET'];
    }

    public function generateToken(array $payload): string
    {
        $issuedAt = time();
        $expire = $issuedAt + 3600; // 1 hora

        $tokenPayload = array_merge(
            $payload,
            [
                'iat' => $issuedAt,
                'exp' => $expire
            ]
        );

        return JWT::encode($tokenPayload, $this->key, 'HS256');
    }

    public function validateToken(string $token): ?object
    {
        try {
            return JWT::decode($token, new Key($this->key, 'HS256'));
        } catch (\Exception $e) {
            return null;
        }
    }
}