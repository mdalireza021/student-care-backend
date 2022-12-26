<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    use HasFactory;

    protected $fillable = [
        'first_name','middle_name','last_name','id_no','school_id','phone','roll_number','student_class_id',
        'section_id','shift_id','gender','blood_type'];

    protected $appends = ['fullname'];

    public function homeTask()
    {
        return $this->belongsToMany(HomeTask::class);
    }

    public function studentClass()
    {
        return $this->belongsTo(StudentClass::class);
    }

    public function addresses()
    {
        return $this->morphMany(Address::class, 'addressable');
    }

    public function image()
    {
        return $this->morphOne(Attachment::class, 'attachable');
    }

    public function currentAddress()
    {
        return $this->morphOne(Address::class, 'addressable')->where('is_current', true);
    }

    public function getFullnameAttribute($value)
    {
        $firstName = $this->first_name;
        $middleName = $this->middle_name;
        $lastName = $this->last_name;

        if ($middleName) {
            return $firstName.' '.$middleName.' '.$lastName;
        } else {
            return $firstName.' '.$lastName;
        }
    }

    public function getGenderAttribute($value)
    {
        $genders = config('app.gender');
        return $genders[$value];
    }

    public function getBloodTypeAttribute($value)
    {
        $bloodTypes = config('app.blood_types');
        return $bloodTypes[$value];
    }

    public function shift()
    {
        return $this->belongsTo(Shift::class);
    }

    public function section()
    {
        return $this->belongsTo(Section::class);
    }

    public function school()
    {
        return $this->belongsTo(School::class);
    }

    public function attendances()
    {
        return $this->hasMany(Attendance::class);
    }

    public function guardian()
    {
        return $this->belongsToMany(Guardian::class);
    }

    public function attachment()
    {
        return $this->morphOne(Attachment::class, 'attachable');
    }
}
