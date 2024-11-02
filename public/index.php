<?php

use Slim\Factory\AppFactory;
use Dougl\Projetoweb\Controllers\ProfessorController;
use Dougl\Projetoweb\Controllers\StudentController;
use Dougl\Projetoweb\Controllers\ProjectController;
use Dougl\Projetoweb\Controllers\SkillController;
use Dougl\Projetoweb\Services\ProfessorService;
use Dougl\Projetoweb\Services\StudentService;
use Dougl\Projetoweb\Services\ProjectService;
use Dougl\Projetoweb\Services\SkillService;
use Dougl\Projetoweb\Middleware\LogMiddleware;
use Dougl\Projetoweb\Middleware\HeadersMiddleware;
use Dougl\Projetoweb\Controllers\AuthController;
use Dougl\Projetoweb\Middleware\JWTAuthMiddleware;
use Dougl\Projetoweb\Controllers\UserController;
use Dougl\Projetoweb\Services\UserService;

require __DIR__ . '/../vendor/autoload.php';
require __DIR__ . '/../config/database.php';

$app = AppFactory::create();

// Professor routes
$professorService = new ProfessorService();
$professorController = new ProfessorController($professorService);

$app->get('/', function ($request, $response) {
    $response->getBody()->write("Bem-vindo à API do Projeto Web");
    return $response;
});

$app->get('/professors', [$professorController, 'getAll']);
$app->get('/professors/{id}', [$professorController, 'getById']);
$app->post('/professors', [$professorController, 'create']);
$app->put('/professors/{id}', [$professorController, 'update']);
$app->delete('/professors/{id}', [$professorController, 'delete']);

// Student routes
$studentService = new StudentService();
$studentController = new StudentController($studentService);

$app->get('/students', [$studentController, 'getAll']);
$app->get('/students/{id}', [$studentController, 'getById']);
$app->post('/students', [$studentController, 'create']);
$app->put('/students/{id}', [$studentController, 'update']);
$app->delete('/students/{id}', [$studentController, 'delete']);
$app->post('/students/{id}/skills', [$studentController, 'addSkills']);

// Project routes
$projectService = new ProjectService();
$projectController = new ProjectController($projectService);

$app->get('/projects', [$projectController, 'getAll']);
$app->get('/projects/{id}', [$projectController, 'getById']);
$app->post('/projects', [$projectController, 'create']);
$app->put('/projects/{id}', [$projectController, 'update']);
$app->delete('/projects/{id}', [$projectController, 'delete']);
$app->post('/projects/{id}/skills', [$projectController, 'addSkills']);

// Skill routes
$skillService = new SkillService();
$skillController = new SkillController($skillService);

$app->get('/skills', [$skillController, 'getAll']);
$app->get('/skills/{id}', [$skillController, 'getById']);
$app->post('/skills', [$skillController, 'create']);
$app->put('/skills/{id}', [$skillController, 'update']);
$app->delete('/skills/{id}', [$skillController, 'delete']);

// User routes
$userService = new UserService();
$userController = new UserController($userService);

$app->get('/users', [$userController, 'getAll'])->add(new JWTAuthMiddleware());
$app->get('/users/{id}', [$userController, 'getById'])->add(new JWTAuthMiddleware());
$app->post('/users', [$userController, 'create'])->add(new JWTAuthMiddleware());
$app->put('/users/{id}', [$userController, 'update'])->add(new JWTAuthMiddleware());
$app->delete('/users/{id}', [$userController, 'delete'])->add(new JWTAuthMiddleware());

// middlewares globais
$app->add(new LogMiddleware());
$app->add(new HeadersMiddleware());

$authController = new AuthController();

// rota de autenticação
$app->post('/auth/login', [$authController, 'login']);

// rota protegida
$app->get('/protected-route', function ($request, $response) {
    $payload = $request->getAttribute('jwt_payload');
    $response->getBody()->write(json_encode([
        'message' => 'Rota protegida acessada com sucesso',
        'user' => $payload
    ]));
    return $response->withHeader('Content-Type', 'application/json');
})->add(new JWTAuthMiddleware());

// Middleware JWT global para todas as rotas
$app->add(function ($request, $handler) {
    $route = $request->getUri()->getPath();
    
    // Lista de rotas que não precisam de autenticação
    $publicRoutes = [
        '/auth/login'
    ];

    // Se não for uma rota pública, aplica o middleware JWT
    if (!in_array($route, $publicRoutes)) {
        $jwtMiddleware = new JWTAuthMiddleware();
        return $jwtMiddleware($request, $handler);
    }

    return $handler->handle($request);
});

$app->run();
