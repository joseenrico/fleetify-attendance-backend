<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\API\ResponseTrait;
use CodeIgniter\HTTP\ResponseInterface;

class AttendanceController extends BaseController
{
    use ResponseTrait;
    protected $format = 'json';

    public function clockIn()
    {
        $rules = ['employee_id' => 'required|string|is_not_unique[employees.employee_id]'];
        if (!$this->validate($rules)) {
            return $this->failValidationErrors($this->validator->getErrors());
        }

        $employeeModel = new \App\Models\Employee();
        $attendanceModel = new \App\Models\Attendance();
        $historyModel = new \App\Models\AttendanceHistory();

        $data = $this->request->getJSON(true);
        $employee = $employeeModel->find($data['employee_id']);
        if (!$employee) return $this->failNotFound('Employee not found');

        $today = date('Y-m-d');
        $existing = $attendanceModel->where('employee_id', $data['employee_id'])
                                    ->where('DATE(clock_in)', $today)
                                    ->first();
        if ($existing) return $this->fail('Already clocked in today', 400);

        $attendanceId = 'ATT-' . strtoupper(uniqid());
        $clockIn = date('Y-m-d H:i:s');

        $db = \Config\Database::connect();
        $db->transStart();

        $attendanceData = [
            'employee_id' => $data['employee_id'],
            'attendance_id' => $attendanceId,
            'clock_in' => $clockIn,
        ];
        $attendanceModel->insert($attendanceData);

        $historyData = [
            'employee_id' => $data['employee_id'],
            'attendance_id' => $attendanceId,
            'date_attendance' => $clockIn,
            'attendance_type' => 1,
            'description' => 'Clock In',
        ];
        $historyModel->insert($historyData);

        $db->transComplete();
        if ($db->transStatus() === false) return $this->failServerError('Transaction failed');

        return $this->respondCreated($attendanceData);
    }

    public function clockOut($attendanceId)
    {
        $attendanceModel = new \App\Models\Attendance();
        $historyModel = new \App\Models\AttendanceHistory();

        $attendance = $attendanceModel->where('attendance_id', $attendanceId)->first();
        if (!$attendance) return $this->failNotFound('Attendance not found');
        if ($attendance['clock_out']) return $this->fail('Already clocked out', 400);

        $clockOut = date('Y-m-d H:i:s');

        $db = \Config\Database::connect();
        $db->transStart();

        $attendanceModel->update($attendance['id'], ['clock_out' => $clockOut]);

        $historyData = [
            'employee_id' => $attendance['employee_id'],
            'attendance_id' => $attendanceId,
            'date_attendance' => $clockOut,
            'attendance_type' => 2,
            'description' => 'Clock Out',
        ];
        $historyModel->insert($historyData);

        $db->transComplete();
        if ($db->transStatus() === false) return $this->failServerError('Transaction failed');

        $updatedAttendance = $attendanceModel->find($attendance['id']);
        return $this->respond($updatedAttendance);
    }

    public function listAttendance()
    {
        $rules = [
            'date' => 'permit_empty|valid_date[Y-m-d]',
            'department_id' => 'permit_empty|numeric',
        ];
        if (!$this->validate($rules)) {
            return $this->failValidationErrors($this->validator->getErrors());
        }

        $date = $this->request->getGet('date');
        $deptId = $this->request->getGet('department_id');

        $db = \Config\Database::connect();
        $builder = $db->table('attendances');
        $builder->select('attendances.*, employees.name as employee_name, departments.department_name, departments.max_clock_in_time, departments.max_clock_out_time');
        $builder->join('employees', 'employees.employee_id = attendances.employee_id');
        $builder->join('departments', 'departments.id = employees.department_id');

        if ($date) $builder->where('DATE(attendances.clock_in)', $date);
        if ($deptId) $builder->where('employees.department_id', $deptId);

        $attendances = $builder->get()->getResultArray();

        foreach ($attendances as &$att) {
            $clockInTime = date('H:i:s', strtotime($att['clock_in']));
            $maxIn = $att['max_clock_in_time'];
            $att['in_status'] = (strtotime($clockInTime) <= strtotime($maxIn)) ? 'On Time' : 'Late';

            $att['out_status'] = null;
            if ($att['clock_out']) {
                $clockOutTime = date('H:i:s', strtotime($att['clock_out']));
                $maxOut = $att['max_clock_out_time'];
                $att['out_status'] = (strtotime($clockOutTime) >= strtotime($maxOut)) ? 'On Time' : 'Early';
            }
        }

        return $this->respond($attendances);
    }
}
