<?php

namespace App\Models;

class Product extends BaseModel
{
    public function getAll(): array
    {
        try {
            $stmt = $this->db->query("SELECT * FROM products");
            return $stmt->fetchAll(\PDO::FETCH_ASSOC);
        } catch (\PDOException $e) {
            throw new \Exception('Database query failed: ' . $e->getMessage());
        }
    }
}
