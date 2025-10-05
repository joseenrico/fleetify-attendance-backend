<?php

namespace App\Models;

use CodeIgniter\Model;

class Attendance extends Model
{
    protected $table = 'attendances';
    protected $primaryKey = 'id';
    protected $returnType = 'array';
    protected $useAutoIncrement = true;
    protected $allowedFields = ['employee_id', 'attendance_id', 'clock_in', 'clock_out'];
    protected $useTimestamps = true;
}
