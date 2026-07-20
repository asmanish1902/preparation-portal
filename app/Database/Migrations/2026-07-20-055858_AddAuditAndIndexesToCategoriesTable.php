<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddAuditAndIndexesToCategoriesTable extends Migration
{
    public function up()
    {
        // 1. Add missing audit columns
        $fields = [
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

        $this->forge->addColumn('categories', $fields);

        // 2. Add performance composite indexes
        $this->db->query('ALTER TABLE `categories` ADD INDEX `idx_status_deleted_at` (`status`, `deleted_at`)');
        $this->db->query('ALTER TABLE `categories` ADD INDEX `idx_sort_created_at` (`sort_order`, `created_at`)');
    }

    public function down()
    {
        // Drop composite indexes first
        $this->db->query('ALTER TABLE `categories` DROP INDEX `idx_status_deleted_at`');
        $this->db->query('ALTER TABLE `categories` DROP INDEX `idx_sort_created_at`');

        // Drop the newly added columns
        $this->forge->dropColumn('categories', ['updated_by', 'deleted_by']);
    }
}
