<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class UpdateOptionsTableStructure extends Migration
{
    public function up()
    {
        // 1. Add missing columns safely
        $addFields = [];

        if (!$this->db->fieldExists('explanation', 'options')) {
            $addFields['explanation'] = [
                'type'  => 'TEXT',
                'null'  => true,
                'after' => 'is_correct',
            ];
        }

        if (!$this->db->fieldExists('status', 'options')) {
            $addFields['status'] = [
                'type'       => 'TINYINT',
                'constraint' => 1,
                'default'    => 1,
                'after'      => 'explanation',
            ];
        }

        if (!$this->db->fieldExists('created_by', 'options')) {
            $addFields['created_by'] = [
                'type'       => 'BIGINT',
                'constraint' => 20,
                'unsigned'   => true,
                'null'       => true,
                'after'      => 'status',
            ];
        }

        if (!$this->db->fieldExists('updated_by', 'options')) {
            $addFields['updated_by'] = [
                'type'       => 'BIGINT',
                'constraint' => 20,
                'unsigned'   => true,
                'null'       => true,
                'after'      => 'created_by',
            ];
        }

        if (!$this->db->fieldExists('deleted_by', 'options')) {
            $addFields['deleted_by'] = [
                'type'       => 'BIGINT',
                'constraint' => 20,
                'unsigned'   => true,
                'null'       => true,
                'after'      => 'updated_by',
            ];
        }

        if (!$this->db->fieldExists('deleted_at', 'options')) {
            $addFields['deleted_at'] = [
                'type' => 'DATETIME',
                'null' => true,
                'after' => 'updated_at',
            ];
        }

        if (!empty($addFields)) {
            $this->forge->addColumn('options', $addFields);
        }

        // 2. Drop unused columns if present
        if ($this->db->fieldExists('sort_order', 'options')) {
            $this->forge->dropColumn('options', 'sort_order');
        }

        // 3. Add composite key for soft deletes and status filters
        $this->forge->addKey(['status', 'deleted_at'], false, false, 'options');
    }

    public function down()
    {
        // Restore sort_order if needed
        if (!$this->db->fieldExists('sort_order', 'options')) {
            $this->forge->addColumn('options', [
                'sort_order' => [
                    'type'    => 'INT',
                    'default' => 0,
                ],
            ]);
        }

        // Drop added columns
        $dropFields = ['explanation', 'status', 'created_by', 'updated_by', 'deleted_by', 'deleted_at'];
        foreach ($dropFields as $field) {
            if ($this->db->fieldExists($field, 'options')) {
                $this->forge->dropColumn('options', $field);
            }
        }
    }
}
