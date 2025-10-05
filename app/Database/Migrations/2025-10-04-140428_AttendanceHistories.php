<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AttendanceHistories extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => ['type' => 'BIGINT', 'unsigned' => true, 'auto_increment' => true],
            'employee_id' => ['type' => 'VARCHAR', 'constraint' => 50],
            'attendance_id' => ['type' => 'VARCHAR', 'constraint' => 100],
            'date_attendance' => ['type' => 'DATETIME'],
            'attendance_type' => ['type' => 'TINYINT'],
            'description' => ['type' => 'TEXT', 'null' => true],
            'created_at' => ['type' => 'DATETIME', 'null' => true],
            'updated_at' => ['type' => 'DATETIME', 'null' => true],
        ]);
        $this->forge->addKey('id', true);
        $this->forge->addForeignKey('employee_id', 'employees', 'employee_id', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('attendance_id', 'attendances', 'attendance_id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('attendance_histories');
    }

    public function down()
    {
        $this->forge->dropTable('attendance_histories');
    }
}
