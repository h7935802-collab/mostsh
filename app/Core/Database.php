<?php

namespace App\Core;

class Database
{
    public \mysqli $conn;

    public function __construct(array $config)
    {
        // Suppress warnings from mysqli connect, we handle it
        mysqli_report(MYSQLI_REPORT_OFF);

        $this->conn = @new \mysqli(
            $config['host'] ?? 'localhost',
            $config['user'] ?? 'root',
            $config['password'] ?? '',
            $config['dbname'] ?? 'emc_db',
            $config['port'] ?? 3306
        );

        if ($this->conn->connect_error) {
            // For now, simple die. In production, maybe log it.
            die("Database Connection failed. Please make sure MySQL is running and the database 'emc_db' exists.");
        }
        
        $this->conn->set_charset("utf8mb4");
    }

    public function prepare($sql)
    {
        return $this->conn->prepare($sql);
    }
    
    public function query($sql)
    {
        return $this->conn->query($sql);
    }
}
