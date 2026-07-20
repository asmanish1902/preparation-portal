<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateQuestionsTable extends Migration
{
    public function up()
    {
        $this->forge->addField([

            'id' => [
                'type' => 'BIGINT',
                'constraint' => 20,
                'unsigned' => true,
                'auto_increment' => true,
            ],

            'exam_id' => [
                'type' => 'BIGINT',
                'constraint' => 20,
                'unsigned' => true,
            ],

            'question' => [
                'type' => 'TEXT',
            ],

            'question_type' => [
                'type' => 'ENUM',
                'constraint' => [
                    'MCQ',
                    'MSQ',
                    'TRUE_FALSE',
                    'DESCRIPTIVE'
                ],
                'default' => 'MCQ',
            ],

            'marks' => [
                'type' => 'DECIMAL',
                'constraint' => '5,2',
                'default' => 1,
            ],

            'negative_marks' => [
                'type' => 'DECIMAL',
                'constraint' => '5,2',
                'default' => 0,
            ],

            'difficulty' => [
                'type' => 'ENUM',
                'constraint' => [
                    'Easy',
                    'Medium',
                    'Hard'
                ],
                'default' => 'Medium',
            ],

            'explanation' => [
                'type' => 'TEXT',
                'null' => true,
            ],

            'sort_order' => [
                'type' => 'INT',
                'default' => 0,
            ],

            'status' => [
                'type' => 'TINYINT',
                'constraint' => 1,
                'default' => 1,
            ],

            'created_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],

            'updated_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],

            'deleted_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],

        ]);

        $this->forge->addKey('id', true);

        $this->forge->addKey('exam_id');
        $this->forge->addKey('status');
        $this->forge->addKey('difficulty');
        $this->forge->addKey('sort_order');

        $this->forge->addForeignKey(
            'exam_id',
            'exams',
            'id',
            'RESTRICT',
            'CASCADE'
        );

        $this->forge->createTable('questions');
    }

    public function down()
    {
        $this->forge->dropTable('questions');
    }
}
