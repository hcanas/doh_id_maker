<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    use HasFactory;

    protected $fillable = [
        'photo',
        'code',
        'given_name',
        'middle_name',
        'family_name',
        'name_suffix',
        'nickname',
        'address',
        'contact_number',
        'email',
        'position',
        'birth_date',
        'sex',
        'blood_type',
        'gsis_number',
        'pagibig_number',
        'philhealth_number',
        'tin_number',
        'emergency_contact',
        'emergency_contact_number',
        'active_from',
        'active_to',
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];
}
