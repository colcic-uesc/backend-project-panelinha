<?php

namespace Dougl\Projetoweb\Controllers;

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Dougl\Projetoweb\Services\ProjectService;
use Dougl\Projetoweb\Models\Project;

class ProjectController {
    private $projectService;

    public function __construct() {
        $this->projectService = new ProjectService();
    }

    public function getAll(Request $request, Response $response) {
        $projects = $this->projectService->getAll();
        $response->getBody()->write(json_encode($projects));
        return $response->withHeader('Content-Type', 'application/json');
    }

    public function getById(Request $request, Response $response, $args) {
        try {
            $project = $this->projectService->getById($args['id']);
            $response->getBody()->write(json_encode($project));
            return $response->withHeader('Content-Type', 'application/json');
        } catch (\Exception $e) {
            $errorMessage = ['error' => $e->getMessage()];
            $response->getBody()->write(json_encode($errorMessage));
            return $response->withHeader('Content-Type', 'application/json')->withStatus(404);
        }
    }

    public function create(Request $request, Response $response) {
        $data = json_decode($request->getBody()->getContents(), true);
        error_log('Dados recebidos (Project): ' . print_r($data, true));
        
        $requiredFields = ['title', 'description', 'type', 'start_date', 'end_date', 'professor_id'];
        $missingFields = [];
        
        foreach ($requiredFields as $field) {
            if (!isset($data[$field]) || trim($data[$field]) === '') {
                $missingFields[] = $field;
            }
        }
        
        if (!empty($missingFields)) {
            $errorMessage = 'Os seguintes campos são obrigatórios: ' . implode(', ', $missingFields);
            $response->getBody()->write(json_encode(['error' => $errorMessage]));
            return $response->withHeader('Content-Type', 'application/json')->withStatus(400);
        }
        
        $project = new Project();
        $project->title = $data['title'];
        $project->description = $data['description'];
        $project->type = $data['type'];
        $project->start_date = $data['start_date'];
        $project->end_date = $data['end_date'];
        $project->professor_id = $data['professor_id'];
        
        try {
            $newProject = $this->projectService->create($project);
            $response->getBody()->write(json_encode($newProject));
            return $response->withHeader('Content-Type', 'application/json')->withStatus(201);
        } catch (\Exception $e) {
            $response->getBody()->write(json_encode(['error' => $e->getMessage()]));
            return $response->withHeader('Content-Type', 'application/json')->withStatus(500);
        }
    }

    public function update(Request $request, Response $response, $args) {
        $data = json_decode($request->getBody()->getContents(), true);

        $requiredFields = ['title', 'description', 'type', 'start_date', 'end_date', 'professor_id'];
        $missingFields = [];
        
        foreach ($requiredFields as $field) {
            if (!isset($data[$field]) || trim($data[$field]) === '') {
                $missingFields[] = $field;
            }
        }

        if (!empty($missingFields)) {
            $errorMessage = 'Os seguintes campos são obrigatórios: ' . implode(', ', $missingFields);
            $response->getBody()->write(json_encode(['error' => $errorMessage]));
            return $response->withHeader('Content-Type', 'application/json')->withStatus(400);
        }
        
        $project = new Project();
        $project->title = $data['title'];
        $project->description = $data['description'];
        $project->type = $data['type'];
        $project->start_date = $data['start_date'];
        $project->end_date = $data['end_date'];
        $project->professor_id = $data['professor_id'];
        
        try {
            $updatedProject = $this->projectService->update($args['id'], $project);
            $response->getBody()->write(json_encode($updatedProject));
            return $response->withHeader('Content-Type', 'application/json');
        } catch (\Exception $e) {
            $response->getBody()->write(json_encode(['error' => $e->getMessage()]));
            return $response->withHeader('Content-Type', 'application/json')->withStatus(404);
        }
    }

    public function delete(Request $request, Response $response, $args) {
       try {
        $result = $this->projectService->delete($args['id']);
        return $response->withStatus(204);
       } catch (\Exception $e) {
        $response->getBody()->write(json_encode(['error' => $e->getMessage()]));
        return $response->withHeader('Content-Type', 'application/json')->withStatus(404);
       }
    }
}