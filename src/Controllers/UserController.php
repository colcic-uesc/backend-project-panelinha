<?php

namespace Dougl\Projetoweb\Controllers;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Dougl\Projetoweb\Models\User;
use Dougl\Projetoweb\Services\UserService;

class UserController {
    private $userService;

    public function __construct(UserService $userService) {
        $this->userService = $userService;
    }

    public function getAll(Request $request, Response $response) {
        try {
            $users = $this->userService->getAll();
            $response->getBody()->write(json_encode($users));
            return $response->withHeader('Content-Type', 'application/json');
        } catch (\Exception $e) {
            $response->getBody()->write(json_encode(['error' => $e->getMessage()]));
            return $response->withHeader('Content-Type', 'application/json')->withStatus(500);
        }
    }

    public function getById(Request $request, Response $response, array $args) {
        try {
            $user = $this->userService->getById($args['id']);
            
            if ($user) {
                $response->getBody()->write(json_encode($user));
                return $response->withHeader('Content-Type', 'application/json');
            }
            
            return $response->withStatus(404);
        } catch (\Exception $e) {
            $response->getBody()->write(json_encode(['error' => $e->getMessage()]));
            return $response->withHeader('Content-Type', 'application/json')->withStatus(500);
        }
    }

    public function create(Request $request, Response $response) {
        $data = json_decode($request->getBody()->getContents(), true);
        
        if (!isset($data['username']) || !isset($data['password']) || !isset($data['rules'])) {
            $response->getBody()->write(json_encode(['error' => 'Username, password e rules são obrigatórios']));
            return $response->withHeader('Content-Type', 'application/json')->withStatus(400);
        }

        try {
            $user = new User();
            $user->username = $data['username'];
            $user->password = $data['password'];
            $user->rules = $data['rules'];

            $newUser = $this->userService->create($user);
            $response->getBody()->write(json_encode($newUser));
            return $response->withHeader('Content-Type', 'application/json')->withStatus(201);
        } catch (\Exception $e) {
            $response->getBody()->write(json_encode(['error' => $e->getMessage()]));
            return $response->withHeader('Content-Type', 'application/json')->withStatus(500);
        }
    }

    public function update(Request $request, Response $response, array $args) {
        $data = json_decode($request->getBody()->getContents(), true);
        
        try {
            $updatedUser = $this->userService->update($args['id'], $data);
            
            if ($updatedUser) {
                $response->getBody()->write(json_encode($updatedUser));
                return $response->withHeader('Content-Type', 'application/json');
            }
            
            return $response->withStatus(404);
        } catch (\Exception $e) {
            $response->getBody()->write(json_encode(['error' => $e->getMessage()]));
            return $response->withHeader('Content-Type', 'application/json')->withStatus(500);
        }
    }

    public function delete(Request $request, Response $response, array $args) {
        try {
            if ($this->userService->delete($args['id'])) {
                return $response->withStatus(204);
            }
            return $response->withStatus(404);
        } catch (\Exception $e) {
            $response->getBody()->write(json_encode(['error' => $e->getMessage()]));
            return $response->withHeader('Content-Type', 'application/json')->withStatus(500);
        }
    }
} 