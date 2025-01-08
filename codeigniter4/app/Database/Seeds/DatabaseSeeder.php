<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        // Call individual seeders in the desired order
        $this->call('Users');
        $this->call('Quizzes');
        $this->call('Questions');
        $this->call('Options');
    }
}
