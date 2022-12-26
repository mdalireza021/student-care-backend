<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AcademicResult extends Model
{
    use HasFactory;

    protected $fillable = [
        "examine_id",
        "session_id",
        "student_class_id",
        "serial",
        "subject_id",
        "exam_id",
        "student_id",
        "total_marks",
        "obtained_marks",
        "highest_marks",
        "gpa",
        "remarks",
    ];

    public function studentClass()
    {
        return $this->belongsTo(StudentClass::class);
    }

    public function exam()
    {
        return $this->belongsTo(Exam::class);
    }

    public function student()
    {
        return $this->belongsTo(Student::class);
    }

    public function subject()
    {
        return $this->belongsTo(Subject::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
