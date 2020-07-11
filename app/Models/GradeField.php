<?php

namespace App\Models;

use App\Models\Base\BaseModel;

class GradeField extends BaseModel
{
    protected $table = 'grade_field';

    protected $fillable = ['grade','type', 'name'];
}
