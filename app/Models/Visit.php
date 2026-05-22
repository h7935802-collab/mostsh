<?php

namespace App\Models;

use App\Core\Model;
use App\Core\Application;

class Visit extends Model
{
    public int $id = 0;
    public int $patient_id = 0;
    public string $arrival_time = '';
    public string $status = 'triage';
    public string $priority = 'non-urgent';

    public function rules(): array
    {
        return [
            'patient_id' => ['required']
        ];
    }

    public function save()
    {
        $sql = "INSERT INTO visits (patient_id, status, priority) 
                VALUES (?, ?, ?)";
        $stmt = Application::$app->db->prepare($sql);
        if (!$stmt) return false;
        
        return $stmt->execute([
            $this->patient_id, 
            $this->status, 
            $this->priority
        ]);
    }

    public function findAllWithPatients()
    {
        $sql = "SELECT v.*, p.full_name, p.national_id 
                FROM visits v 
                JOIN patients p ON v.patient_id = p.id 
                ORDER BY v.arrival_time DESC";
        $result = Application::$app->db->query($sql);
        $visits = [];
        if ($result) {
            while ($row = $result->fetch(\PDO::FETCH_ASSOC)) {
                $visits[] = $row;
            }
        }
        return $visits;
    }

    public function updateStatus(int $id, string $status)
    {
        $sql = "UPDATE visits SET status = ? WHERE id = ?";
        $stmt = Application::$app->db->prepare($sql);
        if (!$stmt) return false;
        return $stmt->execute([$status, $id]);
    }

    public function findOne(int $id)
    {
        $sql = "SELECT v.*, p.full_name, p.national_id, p.dob, p.gender 
                FROM visits v JOIN patients p ON v.patient_id = p.id 
                WHERE v.id = ?";
        $stmt = Application::$app->db->prepare($sql);
        $stmt->execute([$id]);
        $row = $stmt->fetch(\PDO::FETCH_ASSOC);
        if ($row) {
            return $row;
        }
        return false;
    }
}
