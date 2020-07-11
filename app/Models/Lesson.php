<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Base\BaseModel;

class Lesson extends BaseModel
{
    protected $table = 'lesson';
    protected $hidden = ['created_at', 'updated_at'];
}
