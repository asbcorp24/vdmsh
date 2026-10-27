<?php
namespace App\Http\Controllers;
use App\Models\FeedbackMessage;use Illuminate\Http\Request;
class FeedbackController extends Controller{
 public function create(){return view('feedback.index');}
 public function store(Request $r){
  $d=$r->validate(['name'=>'required|max:255','email'=>'nullable|email|max:255','phone'=>'nullable|max:100','topic'=>'nullable|max:255','message'=>'required|max:5000','privacy_consent'=>'accepted','website'=>'nullable|max:0']);
  if(blank($d['email']??null)&&blank($d['phone']??null))return $r->expectsJson()?response()->json(['message'=>'Укажите электронную почту или телефон.','errors'=>['contact'=>['Укажите электронную почту или телефон.']]],422):back()->withErrors(['contact'=>'Укажите электронную почту или телефон.'])->withInput();
  unset($d['website'],$d['privacy_consent']);$d['status']='new';FeedbackMessage::create($d);
  if($r->expectsJson())return response()->json(['message'=>'Обращение отправлено.']);
  return back()->with('sent','Обращение отправлено.');
 }
}