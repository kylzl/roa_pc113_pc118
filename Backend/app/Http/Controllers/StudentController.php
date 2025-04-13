<?php

namespace App\Http\Controllers;

use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class StudentController extends Controller
{
    public function search(Request $request)
    {
        $search = $request->input('search');

        $users = Student::where('lastname', 'LIKE', "%{$search}%")
            ->orWhere('email', 'LIKE', "%{$search}%")
            ->select(['firstname', 'lastname', 'email', 'role', 'image'])
            ->get();

        return response()->json($users);
    }
    public function show()
    {
        $students = Student::select(['firstname', 'lastname', 'email', 'id', 'image'])->get();
        $totalStudents = $students->count();

        return response()->json([
            'data' => $students,
            'total' => $totalStudents
        ]);
    }

    public function create(Request $request)
    {
        $request->validate([
            'firstname' => 'required|string',
            'lastname' => 'required|string',
            'gender' => 'required|string',
            'birthdate' => 'required|date',
            'address' => 'required|string',
            'contact_number' => 'required|string',
            'guardian_name' => 'required|string',
            'guardian_contact_number' => 'required|string',
            'guardian_relationship' => 'required|string',
            'guardian_address' => 'required|string',
            'guardian_email' => 'required|email',
            'email' => 'required|email|unique:users,email',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        $imagePath = $request->hasFile('image') 
            ? $request->file('image')->store('uploads', 'public') 
            : null;


        Student::create([
            'firstname' => $request->firstname,
            'lastname' => $request->lastname,
            'gender' => $request->gender,
            'birthdate' => $request->birthdate,
            'address' => $request->address,
            'contact_number' => $request->contact_number,
            'guardian_name' => $request->guardian_name,
            'guardian_contact_number' => $request->guardian_contact_number,
            'guardian_relationship' => $request->guardian_relationship,
            'guardian_address' => $request->guardian_address,
            'guardian_email' => $request->guardian_email,
            'email' => $request->email,
            'image' => $imagePath,
        ]);

        return response()->json(['message' => 'Student record created successfully!']);
}

public function update(Request $request, $id)
{
    $user = Student::find($id);

    if (!$user) {
        return response()->json(['message' => 'No user found'], 404);
    }

    $validated = $request->validate([
        'firstname' => 'required|string',
        'lastname' => 'required|string',
        'gender' => 'required|string',
        'birthdate' => 'required|date',
        'address' => 'required|string',
        'contact_number' => 'required|string',
        'guardian_name' => 'required|string',
        'guardian_contact_number' => 'required|string',
        'guardian_relationship' => 'required|string',
        'guardian_address' => 'required|string',
        'guardian_email' => 'required|email',
        'email' => 'required|email|unique:users,email,' . $id,
        'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
    ]);

    if ($request->hasFile('image')) {
        $imagePath = $request->file('image')->store('uploads', 'public');
        $validated['image'] = $imagePath;
    }

    $user->update($validated);

    return response()->json(['message' => 'User updated successfully!']);
}

public function delete(string $id)
{
    $user = Student::find($id);
    if (!$user) {
        return response()->json(['message' => 'No student found'], 404);
    }

    if ($user->image) {
        Storage::disk('public')->delete($user->image);
    }

    $user->delete();

    return response()->json(['message' => 'Student record successfully deleted!']);
}
}