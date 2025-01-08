<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class Options extends Seeder
{
    public function run()
    {
        $data = [
            // Question 1
            ['question_id' => 1, 'option_text' => 'variabel', 'is_correct' => true],
            ['question_id' => 1, 'option_text' => 'konstanta', 'is_correct' => false],
            ['question_id' => 1, 'option_text' => 'koefisien', 'is_correct' => false],
            ['question_id' => 1, 'option_text' => 'komutatif', 'is_correct' => false],

            // Question 2
            ['question_id' => 2, 'option_text' => '1', 'is_correct' => true],
            ['question_id' => 2, 'option_text' => '2', 'is_correct' => false],
            ['question_id' => 2, 'option_text' => '0.5', 'is_correct' => false],
            ['question_id' => 2, 'option_text' => '0', 'is_correct' => false],

            // Question 3
            ['question_id' => 3, 'option_text' => '7', 'is_correct' => true],
            ['question_id' => 3, 'option_text' => '8', 'is_correct' => false],
            ['question_id' => 3, 'option_text' => '12', 'is_correct' => false],
            ['question_id' => 3, 'option_text' => '-7', 'is_correct' => false],

            // Question 4
            ['question_id' => 4, 'option_text' => 'x = 7', 'is_correct' => true],
            ['question_id' => 4, 'option_text' => 'x = 6', 'is_correct' => false],
            ['question_id' => 4, 'option_text' => 'x = 5', 'is_correct' => false],
            ['question_id' => 4, 'option_text' => 'x = 3', 'is_correct' => false],

            // Question 5
            ['question_id' => 5, 'option_text' => '64', 'is_correct' => false],
            ['question_id' => 5, 'option_text' => '128', 'is_correct' => false],
            ['question_id' => 5, 'option_text' => '32', 'is_correct' => true],
            ['question_id' => 5, 'option_text' => '256', 'is_correct' => false],
        ];

        $this->db->table('options')->insertBatch($data);
    }
}
