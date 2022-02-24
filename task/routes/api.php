<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\userController;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// USER CONTROLLER
Route::post('/register',[userController::class,'register']);
Route::post('/login','App\Http\Controllers\userController@login');

Route::middleware('auth:sanctum')->group(function () {

// SURVEY CONTROLLER
Route::post('/survey','App\Http\Controllers\surveyController@store');
Route::get('/survey/{id}','App\Http\Controllers\surveyController@show');

// SURVEY QUESTION CONTROLLER
Route::post('/surveyQuestion','App\Http\Controllers\surveyQuestionController@store');

// DOCUMENT CONTROLLER
Route::post('/document','App\Http\Controllers\documentsController@store');

// QUESTION CONTROLLER
Route::post('/question','App\Http\Controllers\questionsController@store');

// Answers CONTROLLER
Route::get('/useranswers/{surveyID}/{idUser}','App\Http\Controllers\answersController@show');
Route::post('surveyAnswers','App\Http\Controllers\answersController@create');
Route::post('addScores','App\Http\Controllers\answersController@addScores');
    
});
