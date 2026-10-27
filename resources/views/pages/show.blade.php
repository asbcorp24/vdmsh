@extends('layouts.app')
@section('title',$page->meta_title ?: $page->title)
@section('meta_description',$page->meta_description)
@section('content')
@include('partials.breadcrumbs',['page'=>$page])
<section class="dynamic-page-hero">
 <div class="dynamic-page-copy">
  @if($page->parent)<a class="eyebrow" href="{{route('page.show',$page->parent)}}">{{$page->parent->title}}</a>@else<span class="eyebrow">Детская школа искусств</span>@endif
  <h1>{{$page->title}}</h1>@if($page->excerpt)<p>{{$page->excerpt}}</p>@endif
 </div>
 <div class="page-art" data-page-art data-page-id="{{$page->id}}" @if($page->stl_model) data-stl="{{asset('storage/'.$page->stl_model)}}" @endif aria-hidden="true"><span class="page-art-note">𝄞</span></div>
</section>
@if($page->children()->where('is_published',true)->exists())<nav class="child-page-nav">@foreach($page->children()->where('is_published',true)->orderBy('sort')->get() as $child)<a href="{{route('page.show',$child)}}"><span>{{str_pad($loop->iteration,2,'0',STR_PAD_LEFT)}}</span>{{$child->title}}</a>@endforeach</nav>@endif
<article class="dynamic-content {{$page->template==='wide'?'is-wide':''}}"><div class="prose">{!! $page->content !!}</div></article>
@endsection