<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;use App\Models\{MenuItem,Page};use Illuminate\Http\Request;
class MenuController extends Controller{
 public function index(){return view('admin.menus.index',['roots'=>MenuItem::with('page')->whereNull('parent_id')->orderBy('location')->orderBy('sort')->get(),'all'=>MenuItem::orderBy('title')->get()]);}
 public function create(){return $this->form(new MenuItem);}
 public function store(Request $r){MenuItem::create($this->data($r));return redirect()->route('admin.menus.index')->with('ok','Пункт меню создан');}
 public function edit(MenuItem $menu){return $this->form($menu);}
 public function update(Request $r,MenuItem $menu){$data=$this->data($r,$menu);if(!empty($data['parent_id']))abort_if($this->descendantIds($menu)->contains((int)$data['parent_id']),422,'Нельзя переместить пункт внутрь его потомка.');$menu->update($data);return redirect()->route('admin.menus.index')->with('ok','Меню обновлено');}
 public function quick(Request $r,MenuItem $menu){$d=$r->validate(['parent_id'=>'nullable|exists:menu_items,id','sort'=>'required|integer|min:0']);if(!empty($d['parent_id'])){abort_if((int)$d['parent_id']===$menu->id,422,'Пункт не может быть родителем самому себе.');abort_if($this->descendantIds($menu)->contains((int)$d['parent_id']),422,'Нельзя создать циклическое меню.');}$menu->update($d);return back()->with('ok','Положение пункта изменено');}
 public function destroy(MenuItem $menu){abort_if($menu->children()->exists(),422,'Сначала переместите или удалите дочерние пункты меню.');$menu->delete();return back();}
 private function form($item){return view('admin.menus.form',['item'=>$item,'parents'=>MenuItem::where('id','!=',$item->id??0)->orderBy('title')->get(),'pages'=>Page::orderBy('title')->get()]);}
 private function data(Request $r,?MenuItem $item=null){$d=$r->validate(['title'=>'required|max:255','parent_id'=>'nullable|exists:menu_items,id','page_id'=>'nullable|exists:pages,id','url'=>'nullable|max:2048','location'=>'required|in:main,footer,service','target'=>'required|in:_self,_blank','sort'=>'nullable|integer|min:0']);if($item&&!empty($d['parent_id']))abort_if((int)$d['parent_id']===$item->id,422,'Пункт не может быть родителем самому себе.');$d['is_active']=$r->boolean('is_active');return $d;}
 private function descendantIds(MenuItem $item){$ids=collect();$queue=MenuItem::where('parent_id',$item->id)->pluck('id');while($queue->isNotEmpty()){$ids=$ids->merge($queue);$queue=MenuItem::whereIn('parent_id',$queue)->pluck('id');}return $ids;}
}