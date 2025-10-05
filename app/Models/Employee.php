<?php

namespace App\Models;

use CodeIgniter\Model;

class Employee extends Model
{
    protected $table = 'employees';
    protected $primaryKey = 'employee_id';
    protected $returnType = 'array';
    protected $useAutoIncrement = false;
    protected $keyType = 'string';
    protected $allowedFields = ['employee_id', 'department_id', 'name', 'address'];
    protected $useTimestamps = true;
}
