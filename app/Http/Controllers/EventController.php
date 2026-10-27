<?php
namespace App\Http\Controllers;use App\Models\Event;
class EventController extends Controller{
 public function index(){return view('events.index',['items'=>Event::published()->upcoming()->orderBy('starts_at')->paginate(12,['*'],'page'),'past'=>Event::published()->past()->with(['performances'])->latest('starts_at')->limit(24)->get()]);}
 public function show(Event $event){abort_unless($event->is_published,404);return view('events.show',compact('event'));}
}