<?php

use App\Http\Controllers\StudentController;
use Illuminate\Support\Facades\Route;

Route::get('/', [StudentController::class, 'index'])->name('students.index');
Route::post('/submit', [StudentController::class, 'store'])->name('students.submit');
