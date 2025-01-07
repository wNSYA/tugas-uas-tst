<?php

namespace App\Models;

use CodeIgniter\Model;

class QuestionModel extends Model
{
    protected $table = 'questions';
    protected $primaryKey = 'id';

    protected $allowedFields = ['quiz_id', 'question_text'];
}
