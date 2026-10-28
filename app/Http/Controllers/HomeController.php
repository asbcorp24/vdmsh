<?php
namespace App\Http\Controllers;
use App\Models\{Event,News,Setting,Department,Teacher,Achievement,Gallery,Page};
class HomeController extends Controller{
 public function __invoke(){
  return view('home',[
   'news'=>News::published()->latest('published_at')->limit(3)->get(),
   'events'=>Event::published()->upcoming()->orderBy('starts_at')->limit(4)->get(),
   'concerts'=>Event::published()->past()->whereIn('event_type',['concert','choreography','performance'])->whereHas('performances.media')->with(['performances'])->latest('starts_at')->limit(4)->get(),
   'departments'=>Department::where('is_active',true)->orderBy('sort')->limit(6)->get(),
   'teachers'=>Teacher::where('is_active',true)->orderBy('sort')->limit(4)->get(),
   'achievements'=>Achievement::where('is_published',true)->latest('event_date')->limit(4)->get(),
   'galleries'=>Gallery::where('is_published',true)->latest('event_date')->limit(3)->get(),
   'officialPages'=>Page::where('section','official')->where('is_published',true)->whereNull('parent_id')->orderBy('sort')->limit(6)->get(),
   'home'=>Setting::whereIn('group',['homepage','links'])->pluck('value','key'),
   'stats'=>['founded'=>Setting::valueOf('founded_year','1958'),'students'=>Setting::valueOf('students_count'),'teachers'=>Setting::valueOf('teachers_count'),'departments'=>Setting::valueOf('departments_count')]
  ]);
 }
}