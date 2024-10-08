<?php

namespace Dougl\Projetoweb\Services;

use Dougl\Projetoweb\Models\Project;
use Illuminate\Database\Capsule\Manager as DB;

class ProjectService {
    public function getAll() {
        return DB::table('projects')->get();
    }

    public function getById($id) {
        $project = DB::table('projects')->find($id);
        
        if (!$project) {
            throw new \Exception("Projeto com ID {$id} não encontrado.");
        }
        
        return $project;
    }

    public function create(Project $project) {
        $professorExists = DB::table('professors')->where('id', $project->professor_id)->exists();
        
        if (!$professorExists) {
            throw new \Exception("Professor com ID {$project->professor_id} não existe.");
        }
    
        $id = DB::table('projects')->insertGetId([
            'title' => $project->title,
            'description' => $project->description,
            'type' => $project->type,
            'start_date' => $project->start_date,
            'end_date' => $project->end_date,
            'professor_id' => $project->professor_id,
        ]);
        return $this->getById($id);
    }

    public function update($id, Project $project) {
        // Verifica se o projeto existe
        $existingProject = DB::table('projects')->find($id);
        
        if (!$existingProject) {
            throw new \Exception("Projeto com ID {$id} não encontrado para atualização.");
        }

        // Verifica se o professor existe
        $professorExists = DB::table('professors')->where('id', $project->professor_id)->exists();
        
        if (!$professorExists) {
            throw new \Exception("Professor com ID {$project->professor_id} não existe. Não é possível atualizar o projeto.");
        }

        $updated = DB::table('projects')
            ->where('id', $id)
            ->update([
                'title' => $project->title,
                'description' => $project->description,
                'type' => $project->type,
                'start_date' => $project->start_date,
                'end_date' => $project->end_date,
                'professor_id' => $project->professor_id,
            ]);

        if (!$updated) {
            throw new \Exception("Falha ao atualizar o projeto com ID {$id}.");
        }
        
        return $this->getById($id);
    }

    public function delete($id) {
        $project = DB::table('projects')->where('id', $id)->delete() > 0;

        if (!$project) {
            throw new \Exception("Falha ao deletar o projeto com ID {$id}.");
        }

        return $project;
    }
}