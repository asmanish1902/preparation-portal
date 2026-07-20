<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddSubjectAndAuditFieldsToExamsTable extends Migration
{
    public function up()
    {
        // 1. Add missing columns
        $fields = [
            'subject_id' => [
                'type'       => 'BIGINT',
                'constraint' => 20,
                'unsigned'   => true,
                'after'      => 'category_id',
            ],
            'updated_by' => [
                'type'       => 'BIGINT',
                'constraint' => 20,
                'unsigned'   => true,
                'null'       => true,
                'after'      => 'created_by',
            ],
            'deleted_by' => [
                'type'       => 'BIGINT',
                'constraint' => 20,
                'unsigned'   => true,
                'null'       => true,
                'after'      => 'updated_by',
            ],
        ];

        $this->forge->addColumn('exams', $fields);

        // 2. Modify existing columns (set defaults & column renames)
        $modifyFields = [
            'duration_minutes' => [
                'type'       => 'INT',
                'constraint' => 5,
                'default'    => 60,
            ],
            'total_marks' => [
                'type'       => 'INT',
                'constraint' => 5,
                'default'    => 100,
            ],
            'pass_marks' => [
                'name'       => 'pass_mark', // Renames pass_marks -> pass_mark
                'type'       => 'INT',
                'constraint' => 5,
                'default'    => 50,
            ],
            'total_questions' => [
                'type'       => 'INT',
                'constraint' => 5,
                'default'    => 0,
            ],
            'created_by' => [
                'type'       => 'BIGINT',
                'constraint' => 20,
                'unsigned'   => true,
                'null'       => true,
            ],
        ];

        $this->forge->modifyColumn('exams', $modifyFields);

        // 3. Add Keys & Indexes
        $this->forge->addKey('subject_id', false, false, 'exams');
        $this->forge->addKey(['status', 'deleted_at'], false, false, 'exams');

        // 4. Add Foreign Key for Subject
        $this->forge->addForeignKey('subject_id', 'subjects', 'id', 'CASCADE', 'RESTRICT', 'exams_subject_id_foreign', 'exams');
    }

    public function down()
    {
        // Drop foreign key & indexes
        $this->forge->dropForeignKey('exams', 'exams_subject_id_foreign');

        // Revert modified columns
        $revertFields = [
            'pass_mark' => [
                'name'       => 'pass_marks',
                'type'       => 'INT',
                'constraint' => 5,
            ],
            'created_by' => [
                'type'       => 'INT',
                'constraint' => 11,
                'unsigned'   => true,
            ],
        ];

        $this->forge->modifyColumn('exams', $revertFields);

        // Drop added columns
        $this->forge->dropColumn('exams', ['subject_id', 'updated_by', 'deleted_by']);
    }
}
