<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;use App\Models\{News,Media};use Illuminate\Http\Request;use Illuminate\Support\{Str,Facades\Storage};
class NewsController extends Controller{
 public function index(){return view('admin.news.index',['items'=>News::latest()->paginate(20)]);}
 public function create(){return view('admin.news.form',['item'=>new News]);}
 public function store(Request $r){$news=News::create($this->data($r));$this->photos($r,$news);return redirect()->route('admin.news.edit',$news)->with('ok','Новость создана');}
 public function edit(News $news){$news->load('media');return view('admin.news.form',['item'=>$news]);}
 public function update(Request $r,News $news){$old=$news->cover;$d=$this->data($r,$news);$news->update($d);if(isset($d['cover'])&&$old&&$old!==$d['cover'])Storage::disk('public')->delete($old);$this->photos($r,$news);return redirect()->route('admin.news.edit',$news)->with('ok','Новость обновлена');}
 public function destroy(News $news){if($news->cover)Storage::disk('public')->delete($news->cover);foreach($news->media as $m){Storage::disk('public')->delete($m->file);$m->delete();}$news->delete();return back()->with('ok','Новость удалена');}
 private function photos(Request $r,News $news):void{
  $r->validate(['photos'=>'nullable|array|max:50','photos.*'=>'image|max:15360','remove_photos'=>'nullable|array','remove_photos.*'=>'integer']);
  foreach((array)$r->input('remove_photos',[]) as $id){$m=$news->media()->where('media.id',$id)->first();if($m){$news->media()->detach($m->id);if(!$m->galleries()->exists()&&!$m->news()->exists()){Storage::disk('public')->delete($m->file);$m->delete();}}}
  $sort=(int)($news->media()->max('news_media.sort')??0)+1;
  foreach($r->file('photos',[]) as $file){$path=$file->store('news/'.date('Y/m'),'public');$m=Media::create(['name'=>$file->getClientOriginalName(),'file'=>$path,'mime'=>$file->getMimeType(),'size'=>$file->getSize(),'alt'=>$news->title,'collection'=>'news']);$news->media()->attach($m->id,['sort'=>$sort++]);}
 }
 private function data(Request $r,?News $item=null):array{$d=$r->validate(['title'=>'required|max:255','excerpt'=>'nullable','content'=>'nullable','published_at'=>'nullable|date','cover'=>'nullable|image|max:10240']);$d['slug']=$this->slug($r->input('slug')?:$d['title'],$item?->id);if($r->hasFile('cover'))$d['cover']=$r->file('cover')->store('news','public');$d['is_published']=$r->boolean('is_published');return $d;}
 private function slug($v,$ignore=null){$base=Str::slug($v)?:'news';$s=$base;$i=2;while(News::where('slug',$s)->when($ignore,fn($q)=>$q->where('id','!=',$ignore))->exists())$s=$base.'-'.$i++;return $s;}
}