<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    use HasFactory;

    protected $fillable = [
        'firstname',
        'lastname',
        'gender',
        'birthdate',
        'address',
        'contact_number',
        'guardian_name',
        'guardian_contact_number',
        'guardian_relationship',
        'guardian_address',
        'guardian_email',
        'email',
        'password',
    ];

}