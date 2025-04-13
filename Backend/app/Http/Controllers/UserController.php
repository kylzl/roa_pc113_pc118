<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function search(Request $request)
    {
        $search = $request->input('search');

        $users = User::where('name', 'LIKE', "%{$search}%")
            ->orWhere('email', 'LIKE', "%{$search}%")
            ->select(['name', 'email', 'role', 'image'])
            ->get();

        return response()->json($users);
    }

    public function getUserInfo(Request $request)
    {
        $user = $request->user();

        return response()->json([
            'name' => $user->name,
            'email' => $user->email,
            'role' => $user->role,
            'image' => $user->image ? asset('storage/' . $user->image) : null
        ]);
    }

    public function show()
    {
        $users = User::select(['name', 'email', 'role', 'id', 'image'])->get();
        $totalUsers = $users->count();

        return response()->json([
            'data' => $users,
            'total' => $totalUsers
        ]);
    }

    public function create(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6',
            'role' => 'sometimes|string',
            'image' => 'sometimes|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        $imagePath = $request->hasFile('image') 
            ? $request->file('image')->store('uploads', 'public') 
            : null;

        $hashedPassword = Hash::make($request->password);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => $hashedPassword,  
            'role' => $request->role,
            'image' => $imagePath,         
        ]);

        return response()->json(['message' => 'User created successfully!']);
}

public function update(Request $request, $id)
{
    $user = User::find($id);

    if (!$user) {
        return response()->json(['message' => 'No user found'], 404);
    }

    $validated = $request->validate([
        'name' => 'required|string',
        'email' => 'required|email|unique:users,email,' . $id,
        'role' => 'required|string|in:admin,manager',
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
    $user = User::find($id);
    if (!$user) {
        return response()->json(['message' => 'No user found'], 404);
    }

    if ($user->image) {
        Storage::disk('public')->delete($user->image);
    }

    $user->delete();

    return response()->json(['message' => 'User successfully deleted!']);
}
}