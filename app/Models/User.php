<?php

namespace App\Models;

use App\Core\Model;
use App\Core\Application;

class User extends Model
{
    public int $id = 0;
    public string $username = '';
    public string $password_hash = '';
    public string $role = '';
    public string $full_name = '';

    public function rules(): array
    {
        return [
            'username' => ['required'],
            'password' => ['required']
        ];
    }

    public function findOne(array $where)
    {
        $tableName = "users";
        $attributes = array_keys($where);
        $sql = implode(" AND ", array_map(fn($attr) => "$attr = ?", $attributes));
        
        $stmt = Application::$app->db->prepare("SELECT * FROM $tableName WHERE $sql");
        if (!$stmt) return false;

        $values = array_values($where);
        $stmt->execute($values);
        
        $row = $stmt->fetch(\PDO::FETCH_ASSOC);
        if ($row) {
            $this->loadData($row);
            return $this;
        }
        return false;
    }

    public function findAll()
    {
        $sql = "SELECT * FROM users ORDER BY created_at DESC";
        $result = Application::$app->db->query($sql);
        $users = [];
        if ($result) {
            while ($row = $result->fetch(\PDO::FETCH_ASSOC)) {
                $users[] = $row;
            }
        }
        return $users;
    }

    public function save()
    {
        $sql = "INSERT INTO users (username, password_hash, role, full_name) 
                VALUES (?, ?, ?, ?)";
        $stmt = Application::$app->db->prepare($sql);
        if (!$stmt) return false;
        
        $hashed_password = password_hash($this->password_hash, PASSWORD_DEFAULT);
        
        return $stmt->execute([
            $this->username, 
            $hashed_password, 
            $this->role, 
            $this->full_name
        ]);
    }
}
