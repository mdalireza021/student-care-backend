<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StudentClass extends Model
{
    use HasFactory;

    protected $fillable = ['name','total_students'];

    public function sections()
    {
        return $this->hasMany(Section::class);
    }

    public function subjects()
    {
        return $this->hasMany(Subject::class);
    }

    public function teacher()
    {
        return $this->belongsToMany(Teacher::class);
    }

    public function student()
    {
        return $this->belongsTo(Student::class);
    }
}
