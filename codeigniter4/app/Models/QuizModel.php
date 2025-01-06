<?php

namespace App\Models;

use CodeIgniter\Model;

class QuizModel extends Model
{
    protected $table = 'quizzes';
    protected $primaryKey = 'id';

    protected $allowedFields = ['title', 'description','created_at'];
}
