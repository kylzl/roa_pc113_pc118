<?php

namespace App\Http\Controllers;

use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;

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


public function uploadCSV(Request $request)
{
    if (!$request->hasFile('csv_file')) {
        return response()->json(['error' => 'No file provided or incorrect input name.'], 400);
    }

    $request->validate([
        'csv_file' => 'required|file|mimes:csv,txt|max:2048',
    ]);

    $file = $request->file('csv_file');
    if (!$file->isValid()) {
        return response()->json(['error' => 'Invalid file upload.'], 400);
    }

    try {
        $path = $file->getRealPath();
        $rows = array_map('str_getcsv', file($path));
    } catch (\Exception $e) {
        return response()->json(['error' => 'Failed to read CSV file: ' . $e->getMessage()], 500);
    }

    if (empty($rows) || count($rows) < 2) {
        return response()->json(['error' => 'CSV file is empty or missing data rows.'], 400);
    }

    $header = array_map('trim', array_shift($rows));
    $inserted = 0;
    $skipped = 0;

    foreach ($rows as $index => $row) {
        if (count($row) !== count($header)) {
            \Log::warning("Row $index column count mismatch", [
                'expected' => count($header),
                'actual' => count($row),
                'row' => $row,
            ]);
            $skipped++;
            continue;
        }

        $rowData = array_combine($header, array_map('trim', $row));


        $birthdate = null;
        if (!empty($rowData['birthdate'])) {
            try {
                $birthdate = Carbon::createFromFormat('m-d-Y', $rowData['birthdate'])->format('Y-m-d');
            } catch (\Exception $e) {
                \Log::warning("Invalid birthdate format", ['birthdate' => $rowData['birthdate']]);
            }
        }

        try {
            Student::create([
                'firstname' => $rowData['firstname'],
                'middlename' => $rowData['middlename'] ?? null,
                'lastname' => $rowData['lastname'],
                'gender' => $rowData['gender'],
                'birthdate' => $birthdate,
                'address' => $rowData['address'] ?? 'N/A',
                'contact_number' => $rowData['contact_number'] ?? 'N/A',
                'guardian_name' => $rowData['guardian_name'] ?? 'N/A',
                'guardian_contact_number' => $rowData['guardian_contact_number'] ?? 'N/A',
                'guardian_relationship' => $rowData['guardian_relationship'] ?? 'N/A',
                'guardian_address' => $rowData['guardian_address'] ?? 'N/A',
                'guardian_email' => $rowData['guardian_email'] ?? 'N/A',
                'email' => $rowData['email'] ?? null,
]);
            $inserted++;
        } catch (\Exception $e) {
            if ($e->getCode() == 23000) {
                \Log::info("Duplicate entry for email: $email", ['row' => $rowData]);
            } else {
                \Log::error("Unexpected error inserting row", [
                    'error' => $e->getMessage(),
                    'row' => $rowData,
                ]);
            }
            $skipped++;
        }
    }

    return response()->json([
        'message' => 'CSV upload complete.',
        'inserted' => $inserted,
        'skipped' => $skipped,
    ]);
}


}

