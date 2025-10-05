<?php

namespace App\Models;

use CodeIgniter\Model;

class Department extends Model
{
    protected $table = 'departments';
    protected $primaryKey = 'id';
    protected $returnType = 'array';
    protected $useAutoIncrement = true;
    protected $allowedFields = ['department_name', 'max_clock_in_time', 'max_clock_out_time'];
    protected $useTimestamps = true;
}
