<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::middleware(['auth:sanctum', 'verified'])->get('/dashboard', function () {
    return Inertia\Inertia::render('Dashboard');
})->name('dashboard');

/*
|--------------------------------------------------------------------------
| Social Routes
|--------------------------------------------------------------------------
|
| Social Login and Registeration Route
|
*/

Route::get('login/{provider}', 'Auth\SocialController@redirectToProvider')->name('social.login');
Route::get('login/{provider}/callback', 'Auth\SocialController@handleProviderCallback');

/*
|--------------------------------------------------------------------------
| Email Route
|--------------------------------------------------------------------------
|
| Send test email to all users
|
*/

Route::get('send-email-to-all-users', 'Email\SendEmailController@sendEmailToUsers');