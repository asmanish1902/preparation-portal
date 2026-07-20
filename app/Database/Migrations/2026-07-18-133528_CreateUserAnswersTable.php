<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateUserAnswersTable extends Migration
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

            'attempt_id' => [
                'type'       => 'BIGINT',
                'constraint' => 20,
                'unsigned'   => true,
            ],

            'question_id' => [
                'type'       => 'BIGINT',
                'constraint' => 20,
                'unsigned'   => true,
            ],

            'option_id' => [
                'type'       => 'BIGINT',
                'constraint' => 20,
                'unsigned'   => true,
            ],

            'is_correct' => [
                'type'       => 'BOOLEAN',
                'default'    => false,
            ],

            'marks_awarded' => [
                'type'       => 'DECIMAL',
                'constraint' => '6,2',
                'default'    => 0,
            ],

            'answered_at' => [
                'type' => 'DATETIME',
                'null' => true,
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

        $this->forge->addKey('attempt_id');
        $this->forge->addKey('question_id');
        $this->forge->addKey('option_id');

        // Prevent duplicate answers for the same question in the same attempt
        $this->forge->addUniqueKey(['attempt_id', 'question_id']);

        $this->forge->addForeignKey(
            'attempt_id',
            'exam_attempts',
            'id',
            'CASCADE',
            'CASCADE'
        );

        $this->forge->addForeignKey(
            'question_id',
            'questions',
            'id',
            'RESTRICT',
            'CASCADE'
        );

        $this->forge->addForeignKey(
            'option_id',
            'options',
            'id',
            'RESTRICT',
            'CASCADE'
        );

        $this->forge->createTable('user_answers');
    }

    public function down()
    {
        $this->forge->dropTable('user_answers');
    }
}
