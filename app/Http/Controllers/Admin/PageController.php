<?php
namespace App\Http\Controllers\Admin;use App\Http\Controllers\Controller;use App\Models\Page;use Illuminate\Http\Request;use Illuminate\Support\Str;
class PageController extends Controller{
 public function index(){return view('admin.pages.index',['items'=>Page::with('parent')->orderBy('parent_id')->orderBy('sort')->paginate(50)]);}
 public function create(){return $this->form(new Page);}
 public function store(Request $r){Page::create($this->data($r));return redirect()->route('admin.pages.index')->with('ok','Страница создана');}
 public function edit(Page $page){return $this->form($page);}
 public function update(Request $r,Page $page){$page->update($this->data($r,$page));return redirect()->route('admin.pages.index')->with('ok','Страница обновлена');}
 public function destroy(Page $page){$page->delete();return back();}
 private function form(Page $item){return view('admin.pages.form',['item'=>$item,'parents'=>Page::where('id','!=',$item->id??0)->orderBy('title')->get()]);}
 private function data(Request $r,?Page $item=null){$d=$r->validate(['parent_id'=>'nullable|exists:pages,id','title'=>'required|max:255','section'=>'nullable|max:100','template'=>'required|in:default,wide,landing','excerpt'=>'nullable','content'=>'nullable','meta_title'=>'nullable|max:255','meta_description'=>'nullable|max:500','sort'=>'nullable|integer']);if($item&&isset($d['parent_id']))abort_if((int)$d['parent_id']===$item->id,422,'Страница не может быть родителем самой себе.');$d['slug']=Str::slug($r->input('slug')?:$d['title']);$d['is_published']=$r->boolean('is_published');return $d;}
}