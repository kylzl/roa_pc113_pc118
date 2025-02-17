<?php

namespace App\Http\Controllers;
use App\Models\User;

abstract class Controller  {
        public function ShowEmployees()
        {
            $users = User::all();
            return response()->json($users);
        }
    }
    
