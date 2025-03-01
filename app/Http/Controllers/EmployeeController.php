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

    public function read()
    {
        $employee = Employee::all();
        return response()->json($employee);
    }

    public function create(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'email' => 'required|unique:Students,email',
            'password' => 'required'
        ]);
        Employee::create($request->all());
        return "User created successfully!";        
    }

    public function update(Request $request, string $id)
    {
        $employee = Employee::find($id);
        if (!$employee) {
            return response()->json(['message' => 'No user found'], 404);
        }

        $request->validate([
            'name' => 'sometimes|required|string',
            'email' => 'sometimes',
            'password' => 'required'
        ]);

        $employee->update($request->all());
        return response()->json(['message' => 'User updated successfully!', 'employee' => $employee]);
    }

    
    public function delete(string $id)
    {
        $student = Employee::find($id);
        if(!$student){
            return "No user found";
        }else
        $student->delete();
        return "User successfully deleted!";
    }
    
}
