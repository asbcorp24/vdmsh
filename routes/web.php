<?php
use App\Http\Controllers\{HomeController,SchoolController,EducationController,DocumentsController,NewsController,EventController};
use Illuminate\Support\Facades\Route;
Route::get('/', HomeController::class)->name('home');
Route::get('/school',[SchoolController::class,'index'])->name('school');
Route::get('/education',EducationController::class)->name('education');
Route::view('/admission','admission.index')->name('admission');
Route::get('/events',[EventController::class,'index'])->name('events');
Route::get('/events/{event:slug}',[EventController::class,'show'])->name('events.show');
Route::get('/news',[NewsController::class,'index'])->name('news');
Route::get('/news/{news:slug}',[NewsController::class,'show'])->name('news.show');
Route::get('/documents',DocumentsController::class)->name('documents');
Route::view('/contacts','contacts.index')->name('contacts');
