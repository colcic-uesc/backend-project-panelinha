<?php

namespace Dougl\Projetoweb\Services;

include 'cors.php';

use Dougl\Projetoweb\Models\Student;
use Illuminate\Database\Capsule\Manager as DB;

class StudentService {
    public function getAll() {
        $students = DB::table('students')->get();
        return $this->addSkillsToStudents($students);
    }

    public function getById($id) {
        $student = DB::table('students')->find($id);
        if ($student) {
            $student->skills = $this->getStudentSkills($id);
        }
        return $student;
    }

    public function create(Student $student) {
        $id = DB::table('students')->insertGetId([
            'registration' => $student->registration,
            'name' => $student->name,
            'email' => $student->email,
            'course' => $student->course,
            'bio' => $student->bio,
        ]);
        return $this->getById($id);
    }

    public function update($id, Student $student) {
        $updated = DB::table('students')
            ->where('id', $id)
            ->update([
                'registration' => $student->registration,
                'name' => $student->name,
                'email' => $student->email,
                'course' => $student->course,
                'bio' => $student->bio,
            ]);
        return $updated ? $this->getById($id) : null;
    }

    public function delete($id) {
        return DB::table('students')->where('id', $id)->delete() > 0;
    }

    public function addSkillsToStudent($studentId, $skillIds) {
        $student = $this->getById($studentId);
        if (!$student) {
            return null;
        }

        foreach ($skillIds as $skillId) {
            DB::table('student_skills')->insertOrIgnore([
                'student_id' => $studentId,
                'skill_id' => $skillId,
            ]);
        }

        return $this->getById($studentId);
    }

    public function getStudentSkills($studentId) {
        $skills = DB::table('skills')
            ->join('student_skills', 'skills.id', '=', 'student_skills.skill_id')
            ->where('student_skills.student_id', $studentId)
            ->select('skills.id', 'skills.title')
            ->get();

        $formattedSkills = [];
        foreach ($skills as $skill) {
            $formattedSkills[$skill->id] = $skill->title;
        }

        return $formattedSkills;
    }

    private function addSkillsToStudents($students) {
        foreach ($students as $student) {
            $student->skills = $this->getStudentSkills($student->id);
        }
        return $students;
    }
}