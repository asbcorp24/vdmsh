<?php
namespace App\Http\Controllers;
use App\Models\{Document,Page};use Illuminate\Http\Request;
class DocumentsController extends Controller{
 public function __invoke(Request $r){return $this->index($r);}
 public function index(Request $r){
  $pages=Page::where('section','official')->where('is_published',true)->whereNull('parent_id')->orderBy('sort')->get();
  $q=Document::where('is_published',true);
  if($r->filled('category'))$q->where('category',$r->string('category'));
  if($r->filled('q')){$s='%'.$r->string('q').'%';$q->where(fn($x)=>$x->where('title','like',$s)->orWhere('number','like',$s)->orWhere('description','like',$s));}
  $items=$q->orderBy('sort')->latest('document_date')->get();$groups=$items->groupBy('category');
  $categories=Document::where('is_published',true)->select('category')->distinct()->orderBy('category')->pluck('category');
  if($r->expectsJson())return response()->json(['count'=>$items->count(),'html'=>view('documents._groups',compact('groups'))->render()]);
  return view('documents.index',compact('groups','categories','pages'));
 }
 public function show(Page $page){
  abort_unless($page->section==='official'&&$page->is_published,404);
  $pages=Page::where('section','official')->where('is_published',true)->whereNull('parent_id')->orderBy('sort')->get();
  $children=$page->children()->where('is_published',true)->orderBy('sort')->get();
  $docs=Document::where('is_published',true)->where(function($q)use($page){$q->where('page_id',$page->id)->orWhere(function($x)use($page){$x->whereNull('page_id')->where('category',$page->title);});})->orderBy('sort')->latest('document_date')->get();
  return view('documents.show',compact('page','pages','children','docs'));
 }
}