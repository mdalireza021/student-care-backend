<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClassRoutine extends Model
{
    use HasFactory;

    protected $fillable = [
        'student_class_id',
        'day',
        'from',
        'to',
        'subject_id',
        'room_no',
    ];

    public function studentClass()
    {
        return $this->belongsTo(StudentClass::class);
    }

    public function subject()
    {
        return $this->belongsTo(Subject::class);
    }
}
