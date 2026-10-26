<?php
use App\Http\Controllers\HomeController;use Illuminate\Support\Facades\Route;
Route::get('/',HomeController::class)->name('home');
foreach(['school'=>'О школе','education'=>'Образование','admission'=>'Поступление','events'=>'Афиша','news'=>'Новости','documents'=>'Сведения об образовательной организации','contacts'=>'Контакты'] as $route=>$title){Route::view('/'.$route,'pages.placeholder',compact('title'))->name($route);}