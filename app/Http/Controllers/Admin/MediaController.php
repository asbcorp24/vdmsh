<?php
namespace App\Http\Controllers\Admin;use App\Http\Controllers\Controller;use App\Models\Media;use Illuminate\Http\Request;use Illuminate\Support\Facades\Storage;
class MediaController extends Controller{
 public function index(){return view('admin.media.index',['items'=>Media::latest()->paginate(30)]);}
 public function store(Request $r){
  if($r->filled('external_url')){$d=$r->validate(['name'=>'required|max:255','external_url'=>'required|url|max:1000','collection'=>'nullable|max:100']);$url=$d['external_url'];$provider=str_contains($url,'youtu.be')||str_contains($url,'youtube.com')?'youtube':(str_contains($url,'rutube.ru')?'rutube':null);if(!$provider)return back()->withErrors(['external_url'=>'Разрешены ссылки только YouTube и Rutube.'])->withInput();Media::create(['name'=>$d['name'],'file'=>'','external_url'=>$url,'provider'=>$provider,'mime'=>'video/external','size'=>0,'collection'=>$d['collection']??'general']);return back()->with('ok','Видео добавлено');}
  $r->validate(['files'=>'required','files.*'=>'file|max:15360|mimes:jpg,jpeg,png,webp,avif,pdf','collection'=>'nullable|max:100']);foreach($r->file('files') as $file){$path=$file->store('media/'.date('Y/m'),'public');Media::create(['name'=>$file->getClientOriginalName(),'file'=>$path,'mime'=>$file->getMimeType(),'size'=>$file->getSize(),'collection'=>$r->input('collection','general')]);}return back()->with('ok','Файлы загружены');
 }
 public function destroy(Media $medium){if($medium->galleries()->exists()||$medium->news()->exists())return back()->withErrors(['media'=>'Медиа используется на сайте. Сначала уберите его из связанного материала.']);if($medium->file)Storage::disk('public')->delete($medium->file);$medium->delete();return back()->with('ok','Медиа удалено');}
}