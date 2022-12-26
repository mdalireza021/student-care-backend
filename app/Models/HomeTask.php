<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HomeTask extends Model
{
    use HasFactory;

    protected $fillable = [
        'student_class_id','student_id','subject_id','published_by','published','completed','reviewed',
        'reviewed_by','done_status','marks','remarks'
    ];

    public function students()
    {
        return $this->belongsToMany(Student::class);
    }

    public function studentClass()
    {
        return $this->belongsTo(StudentClass::class);
    }

    public function publishedBy()
    {
        return $this->belongsTo(Teacher::class, 'published_by');
    }

    public function reviewedBy()
    {
        return $this->belongsTo(Teacher::class, 'reviewed_by');
    }

    public function subject()
    {
        return $this->belongsTo(Subject::class);
    }

    public function attachment()
    {
        return $this->morphOne(Attachment::class, 'attachable');
    }
}
