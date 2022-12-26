<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NoticeBoard extends Model
{
    use HasFactory;

    protected $fillable = [
        'name','file','available_from','available_to','description'
    ];
}
