<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class Questions extends Seeder
{
    public function run()
    {
        $data = [
            [
                'quiz_id' => 1,
                'question_text' => 'Lambang pengganti suatu bilangan yang belum diketahui nilainya adalah...',
            ],
            [
                'quiz_id' => 1,
                'question_text' => 'Nilai maksimal dari fungsi sinus (SIN) adalah...',
            ],
            [
                'quiz_id' => 2,
                'question_text' => 'x+5 = 12, maka nilai x adalah...',
            ],
            [
                'quiz_id' => 1,
                'question_text' => 'Selesaikan persamaan berikut: 2x - 4 = 10',
            ],
            [
                'quiz_id' => 1,
                'question_text' => 'Jika pola bilangan adalah 2, 4, 8, 16, … berapakah suku ke-6?',
            ],
        ];

        $this->db->table('questions')->insertBatch($data);
    }
}
