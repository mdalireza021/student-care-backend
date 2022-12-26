<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Teacher extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id','title','first_name','middle_name','last_name','school_id','phone','section','shift_id','gender',
        'blood_type','designation_id'
    ];

    protected $appends = ['class_ids','subject_ids','fullname'];

    public function getClassIdsAttribute($value)
    {
        $classIds = [];

        foreach ($this->classes as $tc) {
            $classIds[] = $tc->id;
        }

        return $classIds;
    }

    public function getSubjectIdsAttribute($value)
    {
        $subjectIds = [];

        foreach ($this->subjects as $tb) {
            $subjectIds[] = $tb->id;
        }

        return $subjectIds;
    }

    public function subjects()
    {
        return $this->belongsToMany(Subject::class);
    }

    public function classes()
    {
        return $this->belongsToMany(StudentClass::class);
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
        $title = $this->title;
        $firstName = $this->first_name;
        $middleName = $this->middle_name;
        $lastName = $this->last_name;

        if ($middleName) {
            return $title.' '.$firstName.' '.$middleName.' '.$lastName;
        } else {
            return $title.' '.$firstName.' '.$lastName;
        }
    }

    public function getTitleAttribute($value)
    {
        $titles = config('app.title');
        return $value ? $titles[$value] : "";
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

    public function designation()
    {
        return $this->belongsTo(Designation::class);
    }

    public function section()
    {
        return $this->belongsTo(Section::class);
    }

    public function school()
    {
        return $this->belongsTo(School::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function attachment()
    {
        return $this->morphOne(Attachment::class, 'attachable');
    }
}
