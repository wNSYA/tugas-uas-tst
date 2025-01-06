<?php

namespace App\Models;

use CodeIgniter\Model;

class OptionModel extends Model
{
    protected $table = 'options';
    protected $primaryKey = 'id';

    protected $allowedFields = ['question_id', 'option_text', 'is_correct'];
}