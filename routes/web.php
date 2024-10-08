<?php

use App\Http\Controllers\EmailTemplateController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\PdfController;
use App\Http\Controllers\ProductController;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
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

Route::post('/fill-pdf', [PdfController::class, 'fillPdf'])->name('fill.pdf');

Route::get('/', function () {
    return view('welcome');
    // dd(Hash::make('123456'));
});

Route::get('products', [ProductController::class, 'index'])->name('products.index');


//Login
Route::get('/login', [EmployeeController::class, 'login'])->name('login');
Route::post('/login/post', [EmployeeController::class, 'checkLogin'])->name('login.check');
Route::get('/dashboard', [EmployeeController::class, 'dashboard'])->name('dashboard');
Route::get('/logout', [EmployeeController::class, 'logout'])->name('logout');

// Employee
Route::resource('employees', EmployeeController::class);

// Birthday Mail send
Route::get('/email-templates', [EmailTemplateController::class, 'index'])->name('email.templates');
Route::get('/email-templates/create', [EmailTemplateController::class, 'create'])->name('email-templates.create');
Route::post('/email-templates/store', [EmailTemplateController::class, 'store'])->name('email-templates.store');

// Route::get('send-mail', function () {
   
//     $data = ' wish for you on your birthday, whatever you ask may you receive, whatever you seek may you find, whatever you wish may it be fulfilled on your birthday';
//     $subject = 'Happy Birthday Kalpesh';
   
//     Mail::to('ahirkp1997@gmail.com')->send(new \App\Mail\BirthdayPostPublish($data,$subject));
   
//     dd("Email is Sent.");
// });