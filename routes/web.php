<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\Auth\AuthenticatedSessionController as AdminAuthenticatedSessionController;
use App\Http\Controllers\Coaches\Auth\AuthenticatedSessionController as CoachesAuthenticatedSessionController;
use App\Http\Controllers\Admin\HomeController as AdminHomeController;
use App\Http\Controllers\Coaches\HomeController as CoachesHomeController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great! s
|
*/



Route::get('/', function () {           
    return view('design.layouts.pages-layout');
});

Route::get('/g/contact', function () {
    return view('design.layouts.contact-layout');
});

Route::get('/g/terms-and-conditions', function () {
    return view('design.layouts.terms-layout');
});

Route::get('/g/courses', function () {
    return view('design.layouts.courses-layout');
});

Route::get('/g/about', function () {
    return view('design.layouts.about-layout');
});

  Route::get('/login', function () {
      return view('auth.login');
  });

 Route::get('/register', function () {
     return view('auth.register');
 })->name('register');

   Route::get('/dashboard', function () {
       return view('dashboard');
   })->middleware(['auth', 'verified'])->name('dashboard');

   Route::get('/Browse your courses', function () {
    return view('front.layouts.courses-layout');
});

Route::get('/about us', function () {
    return view('front.layouts.about-layout');
});

Route::get('/courses', function () {
    return view('front.layouts.courses-layout');
});

Route::get('/contact us', function () {
    return view('front.layouts.contact-layout');
});