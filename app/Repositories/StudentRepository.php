<?php

namespace App\Repositories;

use App\Models\Student;

class StudentRepository
{
    protected Student $model;

    public function __construct(Student $model)
    {
        $this->model = $model;
    }

    public function getCourseNumber(int $studentId) : array
    {
        $query = $this->model->newQuery();

        return $query
            ->select(['courses.number as courseNumber'])
            ->join('courses', 'courses.id', '=', 'students.course_id')
            ->where('students.id', '=', $studentId)
            ->first()
            ->getAttributes();
    }

    public function getGroupName(int $studentId) : array
    {
        $query = $this->model->newQuery();

        return ['groups' => $query
            ->select(['groups.number as groupNumber','parent_id'])
            ->join('student_group_pivots', 'students.id', '=', 'student_group_pivots.student_id')
            ->join('groups', 'groups.id', '=', 'student_group_pivots.group_id')
            ->where('students.id', '=', $studentId)
            ->get()
            ->toArray()];
    }
}
