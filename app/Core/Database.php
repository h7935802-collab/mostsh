<?php

namespace App\Core;

class Database
{
    public \PDO $conn;

    public function __construct(array $config)
    {
        $driver = $config['driver'] ?? 'pgsql';
        $host = $config['host'] ?? 'localhost';
        $port = $config['port'] ?? 5432;
        $dbname = $config['dbname'] ?? 'emc_db';
        $user = $config['user'] ?? 'postgres';
        $password = $config['password'] ?? '';

        $dsn = "$driver:host=$host;port=$port;dbname=$dbname";

        try {
            $this->conn = new \PDO($dsn, $user, $password);
            $this->conn->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
            $this->conn->setAttribute(\PDO::ATTR_DEFAULT_FETCH_MODE, \PDO::FETCH_ASSOC);
        } catch (\PDOException $e) {
            die("Database Connection failed. Please check your credentials and make sure PostgreSQL is running.");
        }
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
