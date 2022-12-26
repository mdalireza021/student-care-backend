<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subject extends Model
{
    use HasFactory;

    protected $fillable = ['name','student_class_id','code','preferred_books'];

    public function studentClass()
    {
        return $this->belongsTo(StudentClass::class);
    }
}
