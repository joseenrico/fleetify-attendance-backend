<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class DepartmentSeeder extends Seeder
{
    public function run()
    {
        $data = [
            [
                'department_name' => 'IT',
                'max_clock_in_time' => '09:00:00',
                'max_clock_out_time' => '17:00:00',
            ],
            [
                'department_name' => 'HR',
                'max_clock_in_time' => '08:30:00',
                'max_clock_out_time' => '16:30:00',
            ],
        ];
        $this->db->table('departments')->insertBatch($data);
    }
}
