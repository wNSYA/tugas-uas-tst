<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class Users extends Seeder
{
    public function run()
    {
        $data = [
            [
                'username' => 'mambo',
                'email' => 'mambo@mambo.mambo',
                'password' => '$2y$10$Eg12CXr/pCJe2OC0zVxhEe8JgIMWti8oA0fDzpCGhJijTT9pvnGC6',
                'role' => 'User',
            ],
            [
                'username' => 'testuser',
                'email' => 'testuser@example.com',
                'password' => '$2y$10$mtEF97FcrKhskbvU1t45S.Cbn9tiCTOkUvV7A8MW4Udch4MWzSR8.',
                'role' => 'User',
            ],
            [
                'username' => 'mambo2',
                'email' => 'mambo2@mambo.mambo',
                'password' => '$2y$10$KV/ILX4jvaNgG5V1nazOLekMX7EVeBGL./NC96N.Yl9JJ9RAiztxi',
                'role' => 'User',
            ],
            [
                'username' => 'mambo3',
                'email' => 'mambo3@mambo.mambo',
                'password' => '$2y$10$ztR69xjTZ52lf7PIgnb7M.Ga4H.qp1hx5oVxuMMf1FhQSC.3SGAhC',
                'role' => 'User',
            ],
            [
                'username' => 'mambo4',
                'email' => 'mambo4@mambo.mambo',
                'password' => '$2y$10$GF3RD0elZWnG8lt08F8EC.hIMqnjVjUkL4WK8shGMNRFqEopepYAq',
                'role' => 'User',
            ],
            [
                'username' => 'mambo5',
                'email' => 'mambo5@mambo.mambo',
                'password' => '$2y$10$80yuETiNi.DS.A1Z0YfGouzUaRIN5qAMtaSUkOXjNqrQL2IcQ1VyG',
                'role' => 'User',
            ],
            [
                'username' => 'tesmambo',
                'email' => 'tesmambo@gmail.com',
                'password' => '$2y$10$CvdsdV/NA0KgeODlvmkm7e7xhd3NmEXVmuyBlXVM9f8EfhLbtk32O',
                'role' => 'User',
            ],
            [
                'username' => 'mambonael',
                'email' => 'mambonael@example.com',
                'password' => '$2y$10$aFn8jE8feZkKyt5f5tRb4evPuptuCuESO/NKvKhHUMWqfPkjWHYv2',
                'role' => 'Admin',
            ],
            [
                'username' => 'testuser1',
                'email' => 'testuser1@example.com',
                'password' => '$2y$10$zaFrNmFmn6NN4upkWLJv/OG6dIyMSRGXoFpAAgvAqhlJxvHlpoleS',
                'role' => 'User',
            ],
        ];

        foreach ($data as $user) {
            $this->db->table('users')->insert($user);
        }
    }
}
