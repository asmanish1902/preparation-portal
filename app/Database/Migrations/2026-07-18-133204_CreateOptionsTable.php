<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateOptionsTable extends Migration
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

            'question_id' => [
                'type'       => 'BIGINT',
                'constraint' => 20,
                'unsigned'   => true,
            ],

            'option_text' => [
                'type' => 'TEXT',
            ],

            'is_correct' => [
                'type'       => 'BOOLEAN',
                'default'    => false,
            ],

            'sort_order' => [
                'type'       => 'INT',
                'default'    => 0,
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

        $this->forge->addKey('question_id');
        $this->forge->addKey('is_correct');
        $this->forge->addKey('sort_order');

        $this->forge->addForeignKey(
            'question_id',
            'questions',
            'id',
            'CASCADE',
            'CASCADE'
        );

        $this->forge->createTable('options');
    }

    public function down()
    {
        $this->forge->dropTable('options');
    }
}
