<?php
namespace App\Http\Controllers;
use App\Models\Document;use Illuminate\Http\Request;
class DocumentsController extends Controller{
 public function __invoke(Request $r){return $this->index($r);}
 public function index(Request $r){
  $q=Document::where('is_published',true);
  if($r->filled('category'))$q->where('category',$r->string('category'));
  if($r->filled('q')){$s='%'.$r->string('q').'%';$q->where(fn($x)=>$x->where('title','like',$s)->orWhere('number','like',$s)->orWhere('description','like',$s));}
  $items=$q->orderBy('sort')->latest('document_date')->get();$groups=$items->groupBy('category');
  $categories=Document::where('is_published',true)->select('category')->distinct()->orderBy('category')->pluck('category');
  if($r->expectsJson())return response()->json(['count'=>$items->count(),'html'=>view('documents._groups',compact('groups'))->render()]);
  return view('documents.index',compact('groups','categories'));
 }
}