<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
class UserController extends Controller{
 public function index(){return view('admin.users.index',['items'=>User::orderBy('name')->paginate(30)]);}
 public function create(){return view('admin.users.form',['item'=>new User]);}
 public function store(Request $r){User::create($this->data($r));return redirect()->route('admin.users.index')->with('ok','Пользователь создан');}
 public function edit(User $user){return view('admin.users.form',['item'=>$user]);}
 public function update(Request $r,User $user){
  $d=$this->data($r,$user);
  if($user->role==='superadmin'&&($d['role']??null)!=='superadmin'&&User::where('role','superadmin')->count()<=1)return back()->withErrors(['role'=>'Нельзя понизить последнего супер-администратора.'])->withInput();
  $user->update($d);return redirect()->route('admin.users.index')->with('ok','Пользователь обновлён');
 }
 public function destroy(User $user){
  abort_if(auth()->id()===$user->id,422,'Нельзя удалить собственную учётную запись.');
  abort_if($user->role==='superadmin'&&User::where('role','superadmin')->count()<=1,422,'Нельзя удалить последнего супер-администратора.');
  $user->delete();return back()->with('ok','Пользователь удалён');
 }
 private function data(Request $r,?User $item=null):array{
  $d=$r->validate(['name'=>'required|max:255','email'=>['required','email','max:255',Rule::unique('users','email')->ignore($item?->id)],'role'=>['required',Rule::in(['superadmin','admin','editor','teacher'])],'password'=>[$item?'nullable':'required','string','min:10','confirmed']]);
  if(blank($d['password']??null))unset($d['password']);
  return $d;
 }
}