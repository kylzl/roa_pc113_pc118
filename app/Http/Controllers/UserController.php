<?php

namespace App\Http\Controllers;
use App\Models\Employee;
use App\Models\Student;

class UserController extends Controller
{
    public function ShowEmployees(){
        $users = Employee::all();
        return response()->json($users);

    }
    public function ShowStudents(){
        $users = Student::all();
        return response()->json($users);

    }
}
