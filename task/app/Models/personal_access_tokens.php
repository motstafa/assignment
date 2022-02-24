<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class personal_access_tokens extends Model
{
    use HasFactory;
    protected$fillable =['Full texts','id','tokenable_type','tokenable_id','name','token','abilities'];
    protected $table="personal_access_tokens";
}
