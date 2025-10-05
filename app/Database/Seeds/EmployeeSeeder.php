<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class EmployeeSeeder extends Seeder
{
    public function run()
    {
        $data = [
            [
                'employee_id'   => 'E001',
                'department_id' => 1,
                'name'          => 'Jose Enrico Markus',
                'address'       => 'Grogol, Jakarta Barat',
            ],
            [
                'employee_id'   => 'E002',
                'department_id' => 2, 
                'name'          => 'Cici Amanda',
                'address'       => 'Tangerang Selatan',
            ],
            [
                'employee_id'   => 'E003',
                'department_id' => 1,
                'name'          => 'Budi Santoso',
                'address'       => 'Depok',
            ],
        ];
        $this->db->table('employees')->insertBatch($data);
    }
}
