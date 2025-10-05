<?php

namespace App\Models;

use CodeIgniter\Model;

class AttendanceHistory extends Model
{
    protected $table = 'attendance_histories';
    protected $primaryKey = 'id';
    protected $returnType = 'array';
    protected $useAutoIncrement = true;
    protected $allowedFields = ['employee_id', 'attendance_id', 'date_attendance', 'attendance_type', 'description'];
    protected $useTimestamps = true;
}
