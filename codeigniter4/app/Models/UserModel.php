<?php

namespace App\Models;

use CodeIgniter\Model;

class UserModel extends Model
{
    protected $table = 'users';
    protected $primaryKey = 'id';

    protected $allowedFields = ['username', 'email', 'password', 'role'];
    protected $validationRules = [
        'username' => 'required|alpha_numeric_space|min_length[3]|max_length[20]',
        'email' => 'required|valid_email',
        'password' => 'required|min_length[4]',
        'role' => 'required|in_list[Admin,User]'
    ];
}
