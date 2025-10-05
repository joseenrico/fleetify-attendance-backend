<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->setAutoRoute(false);

$routes->resource('departments', ['controller' => 'DepartmentController']);
$routes->resource('employees', ['controller' => 'EmployeeController', 'placeholder' => '(:alphanum)']);

$routes->post('attendance/clock-in', 'AttendanceController::clockIn');
$routes->put('attendance/clock-out/(:segment)', 'AttendanceController::clockOut/$1');
$routes->get('attendance/list', 'AttendanceController::listAttendance');

$routes->options('(:any)', function() {
    return \CodeIgniter\Config\Services::response()
        ->setStatusCode(200)
        ->setHeader('Access-Control-Allow-Origin', '*')
        ->setHeader('Access-Control-Allow-Methods', 'GET, POST, PUT, DELETE, OPTIONS')
        ->setHeader('Access-Control-Allow-Headers', 'Content-Type, Authorization, X-Requested-With')
        ->setBody('OK');
});
