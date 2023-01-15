<?php

namespace App\Enums;

enum TeacherPositionEnum: string
{
    case ASSISTANT = 'assistant';
    case LECTURER = 'lecturer';
    case ASSOCIATE_PROFESSOR = 'associate_professor';
    case PROFESSOR = 'professors';
}