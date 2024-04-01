<?php

use App\Http\Controllers\UserController;
use App\Http\Controllers\SocialController;
use App\Http\Controllers\ScheduleController;
use App\Http\Controllers\AuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use \App\Http\Controllers\CourseController;
use \App\Http\Controllers\CoachController;
use \App\Http\Controllers\StudentController;
use \App\Http\Controllers\AppController;
use \App\Http\Controllers\BranchController;



/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group(['prefix' => 'auth'], function () {
  Route::post('/login', [AuthController::class, 'login']);
  Route::post('/', [AuthController::class, 'createUser']);
  Route::post('/forgot-password', [AuthController::class, 'forgotPassword']);
  Route::middleware('auth:sanctum')->get('/me', [AuthController::class, 'getUserByToken']);
});



//USERS
//Get All Users
Route::get('user', [UserController::class,'getUser']);

//Get Specific User Id
Route::get('user/{id}', [UserController::class,'GetUserId']);

//Add User Student
Route::post('addUser', [UserController::class,'addUser']);

//Update User Student
Route::put('updateUser/{id}', [UserController::class,'updateUser']);

//Delete User Student
Route::delete('deleteUser/{id}', [UserController::class,'deleteUser']);



//SCHEDULE
//Get All Schedules
Route::get('schedule', [ScheduleController::class,'getSchedule']);

//Get Specific Schedule Id
Route::get('schedule/{id}', [ScheduleController::class,'GetScheduleId']);

//Add Schedule Student
Route::post('addSchedule', [ScheduleController::class,'addSchedule']);

//Update Schedule Student
Route::put('updateSchedule/{id}', [ScheduleController::class,'updateSchedule']);

//Delete Schedule Student
Route::delete('deleteSchedule/{id}', [ScheduleController::class,'deleteSchedule']);

//SOCIAL
//Get All Socialsr
Route::get('social', [SocialController::class,'getSocial']);

//Get Specific Social Id
Route::get('social/{id}', [SocialController::class,'GetSocialId']);

//Add Social Student
Route::post('addSocial', [SocialController::class,'addSocial']);

//Update Social Student
Route::put('updateSocial/{id}', [SocialController::class,'updateSocial']);

//Delete Social Student
Route::delete('deleteSocial/{id}', [SocialController::class,'deleteSocial']);

Route::get('/branches/branch', [BranchController::class, 'index']);
Route::get('/branches/{id}', [BranchController::class, 'read']);
Route::post('/branches', [BranchController::class, 'create']);
Route::put('/branches/{id}', [BranchController::class, 'update']);
Route::delete('/branches/{id}', [BranchController::class, 'delete']);

Route::get('/courses/course', [CourseController::class, 'index']);
Route::get('/courses/{id}', [CourseController::class, 'read']);
Route::post('/courses', [CourseController::class, 'create']);
Route::put('/courses/{id}', [CourseController::class, 'update']);
Route::delete('/courses/{id}', [CourseController::class, 'delete']);

Route::get('/students/student', [StudentController::class, 'index']);
Route::get('/students/{id}', [StudentController::class, 'read']);
Route::post('/students', [StudentController::class, 'create']);
Route::put('/students/{id}', [StudentController::class, 'update']);
Route::delete('/students/{id}', [StudentController::class, 'delete']);

Route::get('/coaches/coach', [CoachController::class, 'index']);
Route::get('/coaches/{id}', [CoachController::class, 'read']);
Route::post('/coaches', [CoachController::class, 'create']);
Route::put('/coaches/{id}', [CoachController::class, 'update']);
Route::delete('/coaches/{id}', [CoachController::class, 'delete']);

Route::prefix('users')->group(function() {
  Route::get('{user}', [AppController::class, 'student']);
  Route::get('coaches/{user}', [AppController::class, 'coach']);
});


Route::prefix('userappointment')->group(function () {
  //  Route::get('/users', [AppController::class, 'index']); // Create a new user
  // Route::post('/', [AppController::class, 'create']); // Create a new user
  Route::get('/{id}', [AppController::class, 'show']); // Read a user
  Route::put('/{id}', [AppController::class, 'update']); // Update a user
  // Route::delete('/{id}', [AppController::class, 'destroy']); // Delete a user
});

//Assigned Student to Coach
Route::post('coaches/{coachId}/students/{studentId}', [CoachController::class, 'assignStudent']);

//Student must know their Coach
Route::get('students/{studentId}/coaches  ', [StudentController::class, 'studentwithCoach']);

//Coach must know their Student
Route::get('coaches/{coachId}/students', [CoachController::class, 'coachwithStudents']);


Route::get('/user/{userId}/students', [StudentController::class, 'getStudentsByEnrollment']);

Route::get('/coach/students', [CoachController::class, 'getStudentsForLoggedInCoach']);

// Route::post('/userstudent', [UserController::class, 'storeStudent']); // Endpoint for creating a new user
// Route::put('/userstudent/{user}', [UserController::class, 'updateStudent']); // Endpoint for updating an existing user
// Route::get('/userstudent/{user}', [UserController::class, 'showStudent']); // Endpoint for retrieving user data

// Route::get('/userstudent/{coach}/students', [UserController::class, 'studentsUnderCoach']);

Route::get('/getall/{user}', [UserController::class, 'studentRelationship']);