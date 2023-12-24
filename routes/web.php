<?php

use App\Livewire\Admin\Programmes;
use App\Livewire\CoursesOverview;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::view('/', 'home')->name('home');
Route::get('/courses', CoursesOverview::class)->name('courses');
Route::view('/under-construction','under-construction')->name('under-construction');

Route::middleware(['auth', 'admin', 'active'])->get('/programmes', Programmes::class)->name('programmes');

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
    'active'
])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
});
