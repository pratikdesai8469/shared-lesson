<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Base\BaseModel;

class Lession extends BaseModel
{
    protected $hidden = ['created_at', 'updated_at'];
}
