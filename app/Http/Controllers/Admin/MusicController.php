<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;use App\Models\MusicTrack;use Illuminate\Http\Request;use Illuminate\Support\Facades\Storage;
class MusicController extends Controller{
 public function index(){return view('admin.music.index',['tracks'=>MusicTrack::orderBy('sort_order')->orderBy('id')->get()]);}
 public function store(Request $r){$d=$this->data($r);$f=$r->file('audio_file');$d['file_path']=$f->store('music','public');$d['file_name']=$f->getClientOriginalName();$d['mime_type']=$f->getMimeType();$d['file_size']=$f->getSize();MusicTrack::create($d);return back()->with('ok','Трек добавлен');}
 public function update(Request $r,MusicTrack $music){$d=$this->data($r,true);if($r->hasFile('audio_file')){$f=$r->file('audio_file');if($music->file_path)Storage::disk('public')->delete($music->file_path);$d['file_path']=$f->store('music','public');$d['file_name']=$f->getClientOriginalName();$d['mime_type']=$f->getMimeType();$d['file_size']=$f->getSize();}$music->update($d);return back()->with('ok','Трек сохранён');}
 public function destroy(MusicTrack $music){if($music->file_path)Storage::disk('public')->delete($music->file_path);$music->delete();return back()->with('ok','Трек удалён');}
 private function data(Request $r,bool $edit=false){$d=$r->validate(['title'=>'required|max:255','artist'=>'nullable|max:255','audio_file'=>($edit?'nullable':'required').'|file|max:51200|mimes:mp3,wav,ogg,m4a,aac','sort_order'=>'nullable|integer|min:0']);$d['sort_order']=$d['sort_order']??0;$d['is_active']=$r->boolean('is_active');unset($d['audio_file']);return $d;}
}