<?php

use App\Http\Controllers\NotesController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });
Route::get('/cal',[UserController::class,'calculator']);

Route::post('/register',[UserController::class,'register']);
Route::post('/login',[UserController::class,'login']);
Route::post('/post',[NotesController::class,'create_Note']);
Route::get('/get',[NotesController::class,'getNotes']);
Route::post('/collabarator',[NotesController::class,'collabNotes']);
Route::post('/remove',[NotesController::class,'removeCollabarator']);

Route::post('/logout',[UserController::class,'logout']);