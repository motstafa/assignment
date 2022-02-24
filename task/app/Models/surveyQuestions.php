<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class surveyQuestions extends Model
{
    use HasFactory;
   protected $fillable=['surveyId','questionId','priority'];
   protected $table ="survey_questions";
}
