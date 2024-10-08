<?php

namespace Dougl\Projetoweb\Services;

use Dougl\Projetoweb\Models\Skill;
use Illuminate\Database\Capsule\Manager as DB;

class SkillService {
    public function getAll() {
        return DB::table('skills')->get();
    }

    public function getById($id) {
        $skill = DB::table('skills')->find($id);
        if(!$skill) {
            throw new \Exception("Habilidade com ID {$id} não encontrada.");
        }
        return $skill;
    }

    public function create(Skill $skill) {
        $id = DB::table('skills')->insertGetId([
            'title' => $skill->title,
            'description' => $skill->description,
        ]);
        return $this->getById($id);
    }

    public function update($id, Skill $skill) {
        $updated = DB::table('skills')
            ->where('id', $id)
            ->update([
                'title' => $skill->title,
                'description' => $skill->description,
            ]);

        if (!$updated) {
            throw new \Exception("Falha ao atualizar a habilidade com ID {$id}.");
        }

        return $this->getById($id);
    }

    public function delete($id) {
        $skill = DB::table('skills')->where('id', $id)->delete();
        if (!$skill) {
            throw new \Exception("Falha ao deletar a habilidade com ID {$id}.");
        }
        return $skill;
    }
}