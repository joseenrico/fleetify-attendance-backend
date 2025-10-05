# Fleetify Attendance System - Backend (CodeIgniter 4)

---
A simple attendance system to manage **employees and departments**, record **clock-in** and **clock-out** attendance, and display **employee attendance logs** with punctuality status based on the maximum hours for each department.
- **Backend:** PHP 8 + CodeIgniter 4  
- **Database:** MySQL  
- **Frontend (terpisah):** CodeIgniter (UI)
- **Arsitektur:** RESTful API  

---

## Feature
✅ CRUD **Department**  
✅ CRUD **Employee**  
✅ POST **Clock In** (Attendance)  
✅ PUT **Clock Out** (Clock Out)  
✅ GET **Attendance Records** (with `date` & `department_id` filters)   
 
---

## Structure
app/
├── Controllers/
│   ├── DepartmentController.php
│   ├── EmployeeController.php
│   └── AttendanceController.php
├── Models/
│   ├── DepartmentModel.php
│   ├── EmployeeModel.php
│   └── AttendanceModel.php
├── Database/
│   ├── Migrations/
│   │   ├── 2025-10-01-000001_CreateDepartmentsTable.php
│   │   ├── 2025-10-01-000002_CreateEmployeesTable.php
│   │   └── 2025-10-01-000003_CreateAttendancesTable.php
│   └── Seeds/
│       ├── DepartmentSeeder.php
│       └── EmployeeSeeder.php

## Instalasi & Setup
### 1️. Clone & Install
```bash
git clone https://github.com/<username>/fleetify-attendance-backend.git
cd fleetify-attendance-backend
composer install
````
### 2️. Configuration `.env`
Copy the `.env.example` file and edit it according to your local database:
cp env .env
Isi:
app.baseURL = 'http://localhost:8080/'
database.default.hostname = host_name
database.default.database = fleetify_db
database.default.username = root
database.default.password = 
database.default.DBDriver = MySQLi
```
### 3. Buat Database
```sql
CREATE DATABASE fleetify_db;
```
### 4️. Jalankan Migration & Seeder
```bash
php spark migrate
php spark db:seed DepartmentSeeder
php spark db:seed EmployeeSeeder
```
### 5️. Jalankan Server
```bash
php spark serve
```
Akses:
```
http://localhost:8080/
```

---

## API Documentation

Base URL:

```
http://localhost:8080/
```
All responses are in JSON format.
Use `Content-Type: application/json` for POST/PUT.

---

### Departments
#### GET `/departments`
List all departments.
**Response:**

```json
[
  {
    "id": 1,
    "department_name": "IT",
    "max_clock_in_time": "09:00:00",
    "max_clock_out_time": "17:00:00"
  },
  {
    "id": 2,
    "department_name": "HR",
    "max_clock_in_time": "08:30:00",
    "max_clock_out_time": "16:30:00"
  }
]
```

#### POST `/departments`
**Request:**

```json
{
  "department_name": "Finance",
  "max_clock_in_time": "09:00:00",
  "max_clock_out_time": "17:00:00"
}
```

**Response:**

```json
{
  "status": "success",
  "data": {
    "id": 3,
    "department_name": "Finance"
  }
}
```

#### PUT `/departments/{id}`
**Request:**

```json
{
  "department_name": "IT Support",
  "max_clock_in_time": "09:15:00",
  "max_clock_out_time": "17:15:00"
}
```

#### DELETE `/departments/{id}`
---

### Employees

#### GET `/employees`

**Response:**

```json
[
  {
    "id": 1,
    "employee_id": "EMP001",
    "name": "Jose Enrico",
    "department_name": "IT"
  }
]
```

#### POST `/employees`
**Request:**

```json
{
  "employee_id": "EMP002",
  "name": "Anita",
  "department_id": 2,
  "address": "Jakarta"
}
```

---

### Attendance

#### POST `/attendance/clock-in`

**Request:**

```json
{
  "employee_id": "EMP001"
}
```

**Response:**

```json
{
  "status": "success",
  "attendance_uid": "ATT-20251005-EMP001",
  "in_status": "On Time"
}
```

---

#### PUT `/attendance/clock-out/{attendance_uid}`
Record attendance based on `attendance_uid`.

**Response:**

```json
{
  "status": "success",
  "out_status": "On Time"
}
```

---

#### GET `/attendance/list?date=2025-10-05&department_id=1`
Display attendance list (optional filter by date & department).
**Response:**

```json
[
  {
    "employee_id": "EMP001",
    "employee_name": "Jose Enrico",
    "department_name": "IT",
    "clock_in": "2025-10-05 08:55:00",
    "clock_out": "2025-10-05 17:10:00",
    "in_status": "On Time",
    "out_status": "On Time"
  },
  {
    "employee_id": "EMP002",
    "employee_name": "Anita",
    "department_name": "HR",
    "clock_in": "2025-10-05 08:45:00",
    "clock_out": "2025-10-05 16:00:00",
    "in_status": "On Time",
    "out_status": "Early Leave"
  }
]
```
 © 2025 Developed by **Jose Enrico Markus Napitupulu**

---
## Contact

📨 Email: [joseenriconapitupulu@gmail.com](mailto:joseenriconapitupulu@gmail.com)
📱 WhatsApp: +62 812-8406-1723
🌐 GitHub: [github.com/<username>](https://github.com/)

---
