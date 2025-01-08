<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class Quizzes extends Seeder
{
    public function run()
    {
        $data = [
            [
                'title' => 'Kuis Keseluruhan',
                'description' => 'Kuis untuk keseluruhan materi yang tersedia',
            ],
            [
                'title' => 'Kuis Aljabar',
                'description' => 'Kuis untuk materi aljabar',
            ],
            [
                'title' => 'Kuis Trigonometri',
                'description' => 'Kuis untuk materi trigonometri',
            ],
            [
                'title' => 'Kuis Geometri',
                'description' => 'Kuis untuk materi Geometri',
            ],
            [
                'title' => 'Kuis Statistika dan Probabilitas',
                'description' => 'Kuis untuk materi Statistika dan Probabilitas',
            ],
            [
                'title' => 'Kuis Bilangan dan Pola',
                'description' => 'Kuis untuk materi Bilangan dan Pola',
            ],
        ];

        $this->db->table('quizzes')->insertBatch($data);
    }
}
