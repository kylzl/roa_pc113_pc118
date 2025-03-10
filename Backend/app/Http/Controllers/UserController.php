<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function search(Request $request)
    {
        $search = $request->input('search');

        $users = User::where('name', 'LIKE', "%{$search}%")
            ->orWhere('email', 'LIKE', "%{$search}%")
            ->get();
        return response()->json($users);
    }

    public function read()
    {
        $users = User::all();
        return response()->json($users);
    }

    public function create(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'email' => 'required|unique:users,email',
            'password' => 'required'
        ]);
        User::create($request->all());
        return "User created successfully!";        
    }

    public function update(Request $request, string $id)
    {
        $User = User::find($id);
        if (!$User) {
            return response()->json(['message' => 'No user found'], 404);
        }

        $request->validate([
            'name' => 'sometimes|required|string',
            'email' => 'sometimes',
            'password' => 'required'
        ]);

        $User->update($request->all());
        return response()->json(['message' => 'User updated successfully!', 'User' => $User]);
    }

    
    public function delete(string $id)
    {
        $user = User::find($id);
        if(!$user){
            return "No user found";
        }else
        $user->delete();
        return "User successfully deleted!";
    }
    
}
