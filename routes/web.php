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
Route::get('/achievements',AchievementController::class)->name('achievements');
Route::get('/gallery',[GalleryController::class,'index'])->name('gallery');
Route::view('/methodical','methodical.index')->name('methodical');
Route::view('/creative','creative.index')->name('creative');

use App\Http\Controllers\Admin\DepartmentController as AdminDepartment;
use App\Http\Controllers\Admin\TeacherController as AdminTeacher;
use App\Http\Controllers\Admin\ProgramController as AdminProgram;
use App\Http\Controllers\Admin\DocumentController as AdminDocument;
use App\Http\Controllers\Admin\PageController as AdminPage;
use App\Http\Controllers\Admin\MediaController as AdminMedia;
use App\Http\Controllers\PageController as PublicPage;
use App\Http\Controllers\AchievementController;
use App\Http\Controllers\GalleryController;
use App\Http\Controllers\Admin\AchievementController as AdminAchievement;
use App\Http\Controllers\Admin\AuthController as AdminAuth;
use App\Http\Controllers\Admin\DashboardController as AdminDashboard;
use App\Http\Controllers\Admin\NewsController as AdminNews;
use App\Http\Controllers\Admin\EventController as AdminEvent;
Route::middleware('guest')->group(function(){Route::get('/admin/login',[AdminAuth::class,'form'])->name('admin.login');Route::post('/admin/login',[AdminAuth::class,'login'])->name('admin.login.submit');});
Route::prefix('admin')->name('admin.')->middleware(['auth','admin'])->group(function(){Route::get('/',AdminDashboard::class)->name('dashboard');Route::resource('news',AdminNews::class)->except('show');Route::resource('events',AdminEvent::class)->except('show');Route::resource('departments',AdminDepartment::class)->except('show');Route::resource('teachers',AdminTeacher::class)->except('show');Route::resource('programs',AdminProgram::class)->except('show');Route::resource('documents',AdminDocument::class)->except('show');Route::resource('pages',AdminPage::class)->except('show');Route::get('media',[AdminMedia::class,'index'])->name('media.index');Route::post('media',[AdminMedia::class,'store'])->name('media.store');Route::delete('media/{medium}',[AdminMedia::class,'destroy'])->name('media.destroy');Route::resource('achievements',AdminAchievement::class)->except('show');Route::post('/logout',[AdminAuth::class,'logout'])->name('logout');});

Route::get('/p/{page:slug}',[PublicPage::class,'show'])->name('page.show');
