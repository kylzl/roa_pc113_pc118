<?php

namespace App\Http\Controllers;

use App\Models\Student;
use Illuminate\Http\Request;

class StudentController extends Controller
{
    public function search(Request $request)
    {
        $search = $request->input('search');

        $students = Student::where('name', 'LIKE', "%{$search}%")
            ->orWhere('email', 'LIKE', "%{$search}%")
            ->get();
        return response()->json($students);
    }

    public function read()
    {
        $students = Student::all();
        return response()->json($students);
    }

    public function create(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'email' => 'required|unique:Students,email',
            'password' => 'required'
        ]);
        Student::create($request->all());
        return "User created successfully!";        
    }

    public function update(Request $request, string $id)
    {
        $student = Student::find($id);
        if (!$student) {
            return response()->json(['message' => 'No user found'], 404);
        }

        $request->validate([
            'name' => 'sometimes|required|string',
            'email' => 'sometimes',
            'password' => 'required'
        ]);

        $student->update($request->all());
        return response()->json(['message' => 'User updated successfully!', 'student' => $student]);
    }

    
    public function delete(string $id)
    {
        $student = Student::find($id);
        if(!$student){
            return "No user found";
        }else
        $student->delete();
        return "User successfully deleted!";
    }
    
}
