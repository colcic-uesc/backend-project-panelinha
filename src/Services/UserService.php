<?php

namespace Dougl\Projetoweb\Services;

use Dougl\Projetoweb\Models\User;
use Illuminate\Database\Capsule\Manager as DB;

class UserService {
    public function getAll() {
        return DB::table('users')->select(['id', 'username', 'rules'])->get();
    }

    public function getById($id) {
        return DB::table('users')
            ->select(['id', 'username', 'rules'])
            ->find($id);
    }

    public function create(User $user) {
        $user->password = password_hash($user->password, PASSWORD_DEFAULT);
        
        $id = DB::table('users')->insertGetId([
            'username' => $user->username,
            'password' => $user->password,
            'rules' => $user->rules
        ]);
        
        return $this->getById($id);
    }

    public function update($id, array $data) {
        $updateData = [];
        
        if (isset($data['username'])) {
            $updateData['username'] = $data['username'];
        }
        
        if (isset($data['password'])) {
            $updateData['password'] = password_hash($data['password'], PASSWORD_DEFAULT);
        }
        
        if (isset($data['rules'])) {
            $updateData['rules'] = $data['rules'];
        }

        $updated = DB::table('users')
            ->where('id', $id)
            ->update($updateData);

        return $updated ? $this->getById($id) : null;
    }

    public function delete($id) {
        return DB::table('users')->where('id', $id)->delete() > 0;
    }
} 