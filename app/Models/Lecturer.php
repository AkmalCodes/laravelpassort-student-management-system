<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Lecturer extends Model
{
    use HasFactory;

    protected $fillable = [
        'lecturer_name',
        'lecturer_email',
        'lecturer_address',
        'lecturer_faculty',
        'lecturer_specialization'
    ];
}
