<?php

namespace App\Http\Controllers;
use App\Models\User;

class EmployeeController extends Controller {
    public function showEmployees()
    {
        $users = User::all();
        return response()->json($users);
    }
}
