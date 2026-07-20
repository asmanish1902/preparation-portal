<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateExamAttemptsTable extends Migration
{
    public function up()
    {
        $this->forge->addField([

            'id' => [
                'type'           => 'BIGINT',
                'constraint'     => 20,
                'unsigned'       => true,
                'auto_increment' => true,
            ],

            'user_id' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
            ],

            'exam_id' => [
                'type'       => 'BIGINT',
                'constraint' => 20,
                'unsigned'   => true,
            ],

            'attempt_number' => [
                'type'       => 'INT',
                'default'    => 1,
            ],

            'started_at' => [
                'type' => 'DATETIME',
            ],

            'submitted_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],

            'time_taken_seconds' => [
                'type'       => 'INT',
                'default'    => 0,
            ],

            'total_questions' => [
                'type'       => 'INT',
                'default'    => 0,
            ],

            'attempted_questions' => [
                'type'       => 'INT',
                'default'    => 0,
            ],

            'correct_answers' => [
                'type'       => 'INT',
                'default'    => 0,
            ],

            'wrong_answers' => [
                'type'       => 'INT',
                'default'    => 0,
            ],

            'unanswered_questions' => [
                'type'       => 'INT',
                'default'    => 0,
            ],

            'total_marks' => [
                'type'       => 'DECIMAL',
                'constraint' => '6,2',
                'default'    => 0,
            ],

            'marks_obtained' => [
                'type'       => 'DECIMAL',
                'constraint' => '6,2',
                'default'    => 0,
            ],

            'percentage' => [
                'type'       => 'DECIMAL',
                'constraint' => '5,2',
                'default'    => 0,
            ],

            'status' => [
                'type'       => 'VARCHAR',
                'constraint' => 20,
                'default'    => 'IN_PROGRESS',
            ],

            'created_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],

            'updated_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],

        ]);

        $this->forge->addKey('id', true);

        $this->forge->addKey('user_id');
        $this->forge->addKey('exam_id');
        $this->forge->addKey('status');

        $this->forge->addForeignKey(
            'user_id',
            'users',
            'id',
            'CASCADE',
            'CASCADE'
        );

        $this->forge->addForeignKey(
            'exam_id',
            'exams',
            'id',
            'RESTRICT',
            'CASCADE'
        );

        $this->forge->createTable('exam_attempts');
    }

    public function down()
    {
        $this->forge->dropTable('exam_attempts');
    }
}
