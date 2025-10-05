<?php
namespace App\Controllers;

use CodeIgniter\API\ResponseTrait;
use CodeIgniter\RESTful\ResourceController;
use CodeIgniter\Validation\Exceptions\ValidationException;

class DepartmentController extends ResourceController
{
    use ResponseTrait;
    protected $modelName = 'App\Models\Department';
    protected $format = 'json';

    public function index()
    {
        return $this->respond($this->model->findAll());
    }

    public function show($id = null)
    {
        $data = $this->model->find($id);
        if (!$data) return $this->failNotFound('Department not found');
        return $this->respond($data);
    }

  public function create()
{
    $rules = [
        'department_name' => 'required|string|max_length[255]',
        'max_clock_in_time' => 'required|valid_date[H:i:s]',
        'max_clock_out_time' => 'required|valid_date[H:i:s]',
    ];
    if (!$this->validate($rules)) {
        return $this->failValidationErrors($this->validator->getErrors());
    }

    $data = $this->request->getJSON(true); 
    if (empty($data)) {
        return $this->fail('No data provided', 400);
    }

    $id = $this->model->insert($data);
    if (!$id) return $this->failServerError('Failed to create');
    $data['id'] = $id;
    return $this->respondCreated($data);
}

public function update($id = null)
{
    $rules = [
        'department_name' => 'string|max_length[255]',
        'max_clock_in_time' => 'valid_date[H:i:s]',
        'max_clock_out_time' => 'valid_date[H:i:s]',
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
        return $this->respondDeleted(['id' => $id]);
    }
}