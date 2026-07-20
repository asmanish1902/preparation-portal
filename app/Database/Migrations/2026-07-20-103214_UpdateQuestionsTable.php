<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class UpdateQuestionsTableStructure extends Migration
{
    public function up()
    {
        // 1. Rename 'question' to 'question_text' if it exists under the old name
        if ($this->db->fieldExists('question', 'questions')) {
            $this->forge->modifyColumn('questions', [
                'question' => [
                    'name' => 'question_text',
                    'type' => 'TEXT',
                ],
            ]);
        }

        // 2. Modify existing columns safely if they exist
        if ($this->db->fieldExists('question_type', 'questions')) {
            $this->forge->modifyColumn('questions', [
                'question_type' => [
                    'type'       => 'VARCHAR',
                    'constraint' => 20,
                    'default'    => 'single',
                ],
            ]);
        }

        if ($this->db->fieldExists('marks', 'questions')) {
            $this->forge->modifyColumn('questions', [
                'marks' => [
                    'type'       => 'INT',
                    'constraint' => 5,
                    'default'    => 1,
                ],
            ]);
        }

        // 3. Add audit fields only if missing
        $addFields = [];

        if (!$this->db->fieldExists('created_by', 'questions')) {
            $addFields['created_by'] = [
                'type'       => 'BIGINT',
                'constraint' => 20,
                'unsigned'   => true,
                'null'       => true,
                'after'      => 'status',
            ];
        }

        if (!$this->db->fieldExists('updated_by', 'questions')) {
            $addFields['updated_by'] = [
                'type'       => 'BIGINT',
                'constraint' => 20,
                'unsigned'   => true,
                'null'       => true,
                'after'      => 'created_by',
            ];
        }

        if (!$this->db->fieldExists('deleted_by', 'questions')) {
            $addFields['deleted_by'] = [
                'type'       => 'BIGINT',
                'constraint' => 20,
                'unsigned'   => true,
                'null'       => true,
                'after'      => 'updated_by',
            ];
        }

        if (!empty($addFields)) {
            $this->forge->addColumn('questions', $addFields);
        }

        // 4. Safely drop unused columns individually after verifying existence
        $columnsToDrop = ['negative_marks', 'difficulty', 'sort_order'];

        foreach ($columnsToDrop as $column) {
            if ($this->db->fieldExists($column, 'questions')) {
                $this->forge->dropColumn('questions', $column);
            }
        }

        // 5. Add composite index for soft deletes and status filters
        $this->forge->addKey(['status', 'deleted_at'], false, false, 'questions');
    }

    public function down()
    {
        // 1. Drop added audit fields
        $auditFields = ['created_by', 'updated_by', 'deleted_by'];
        foreach ($auditFields as $field) {
            if ($this->db->fieldExists($field, 'questions')) {
                $this->forge->dropColumn('questions', $field);
            }
        }

        // 2. Revert column names
        if ($this->db->fieldExists('question_text', 'questions')) {
            $this->forge->modifyColumn('questions', [
                'question_text' => [
                    'name' => 'question',
                    'type' => 'TEXT',
                ],
            ]);
        }
    }
}
