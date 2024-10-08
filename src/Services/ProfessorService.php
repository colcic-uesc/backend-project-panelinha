<?php

namespace Dougl\Projetoweb\Services;

use Dougl\Projetoweb\Models\Professor;
use Illuminate\Database\Capsule\Manager as DB;

class ProfessorService {
    public function getAll() {
        return DB::table('professors')->get();
    }

    public function getById($id) {
        return DB::table('professors')->find($id);
    }

    public function create(Professor $professor) {
        $id = DB::table('professors')->insertGetId([
            'name' => $professor->name,
            'email' => $professor->email,
            'department' => $professor->department,
            'bio' => $professor->bio,
        ]);
        return $this->getById($id);
    }

    public function update($id, Professor $professor) {
        $updated = DB::table('professors')
            ->where('id', $id)
            ->update([
                'name' => $professor->name,
                'email' => $professor->email,
                'department' => $professor->department,
                'bio' => $professor->bio,
            ]);
        return $updated ? $this->getById($id) : null;
    }

    public function delete($id) {
        return DB::table('professors')->where('id', $id)->delete() > 0;
    }
}