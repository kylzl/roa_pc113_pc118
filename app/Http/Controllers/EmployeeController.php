<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use Illuminate\Http\Request;

class EmployeeController extends Controller
{
    public function search(Request $request)
    {
        $search = $request->input('search');

        $employees = Employee::where('name', 'LIKE', "%{$search}%")
            ->orWhere('email', 'LIKE', "%{$search}%")
            ->get();
        return response()->json($employees);
    }

    public function showEmployees()
    {
        $employees = Employee::all();
        return response()->json($employees);
    }
}
