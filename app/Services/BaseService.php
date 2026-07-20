<?php

namespace App\Services;

use Config\Database;
use Throwable;

abstract class BaseService
{
    protected $db;

    public function __construct()
    {
        $this->db = Database::connect();
    }

    /**
     * Executes a database transaction and wraps the response in a ServiceResult.
     */
    protected function transaction(callable $callback): ServiceResult
    {
        $this->db->transBegin();

        try {
            $data = $callback();

            if ($this->db->transStatus() === false) {
                $this->db->transRollback();
                return ServiceResult::failure('Database transaction failed.');
            }

            $this->db->transCommit();

            return $data instanceof ServiceResult
                ? $data
                : ServiceResult::success('Operation completed successfully.', $data);
        } catch (Throwable $e) {
            $this->db->transRollback();
            log_message('error', '[BaseService Transaction Error]: ' . $e->getMessage(), ['exception' => $e]);

            return ServiceResult::failure($e->getMessage());
        }
    }
}
