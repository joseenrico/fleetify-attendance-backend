<?php
namespace App\Controllers;

use App\Models\Department;
use CodeIgniter\API\ResponseTrait;
use CodeIgniter\RESTful\ResourceController;

class EmployeeController extends ResourceController
{
    use ResponseTrait;
    protected $modelName = 'App\Models\Employee';
    protected $format = 'json';

    public function index()
    {
        return $this->respond($this->model->findAll());
    }

    public function show($id = null)
    {
        $data = $this->model->find($id);
        if (!$data) return $this->failNotFound('Employee not found');
        return $this->respond($data);
    }

public function create()
{
    $rules = [
        'employee_id' => 'required|string|max_length[50]|is_unique[employees.employee_id]',
        'department_id' => 'required|numeric|is_not_unique[departments.id]',
        'name' => 'required|string|max_length[255]',
        'address' => 'required|string',
    ];
    if (!$this->validate($rules)) {
        return $this->failValidationErrors($this->validator->getErrors());
    }

    $data = $this->request->getJSON(true); 
    if (empty($data)) {
        return $this->fail('No data provided', 400);
    }

    if (!$this->model->insert($data)) return $this->failServerError('Failed to create');
    return $this->respondCreated($data);
}

public function update($id = null)
{
    $rules = [
        'department_id' => 'numeric|is_not_unique[departments.id]',
        'name' => 'string|max_length[255]',
        'address' => 'string',
    ];
    if (!$this->validate($rules)) {
        return $this->failValidationErrors($this->validator->getErrors());
    }

    $data = $this->request->getJSON(true);
    if (empty($data)) {
        return $this->fail('No data provided', 400);
    }

    if (!$this->model->update($id, $data)) return $this->failServerError('Failed to update');
    return $this->respond($data);
}

    public function delete($id = null)
    {
        if (!$this->model->delete($id)) return $this->failServerError('Failed to delete');
        return $this->respondDeleted(['employee_id' => $id]);
    }
}