<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Options extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type' => 'SERIAL',
                'auto_increment' => true,
                'unsigned' => true,
            ],
            'question_id' => [
                'type' => 'INT',
                'null' => false,
                'unsigned' => true,
            ],
            'option_text' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => false,
            ],
            'is_correct' => [
                'type' => 'BOOLEAN',
                'null' => false,
            ],
            'created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP',
        ]);

        $this->forge->addKey('id', true);
        $this->forge->addForeignKey('question_id', 'questions', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('options');
    }

    public function down()
    {
        $this->forge->dropTable('options');
    }
}
