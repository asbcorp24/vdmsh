@extends('admin.layout')
@section('title','Музыка сайта')
@section('heading','Музыка сайта')
@section('content')
<form class="panel" method="post" enctype="multipart/form-data" action="{{route('admin.music.store')}}">@csrf
<div class="form-grid"><div><div class="field"><label>Название трека</label><input name="title" required></div><div class="field"><label>Исполнитель</label><input name="artist"></div><div class="field"><label>Аудиофайл</label><input type="file" name="audio_file" accept=".mp3,.wav,.ogg,.m4a,.aac,audio/*" required></div></div><div><div class="field"><label>Порядок</label><input type="number" name="sort_order" min="0" value="0"></div><label class="check"><input type="checkbox" name="is_active" value="1" checked> Показывать в плеере</label><p><button class="button">Добавить трек</button></p></div></div>
</form>
<section class="panel"><h2>Плейлист</h2><table class="admin-table"><thead><tr><th>Трек</th><th>Файл</th><th>Статус</th><th></th></tr></thead><tbody>@forelse($tracks as $track)<tr><td data-label="Трек"><b>{{$track->title}}</b><br><small>{{$track->artist}}</small></td><td data-label="Файл"><a href="{{$track->file_url}}" target="_blank">{{$track->file_name}}</a></td><td data-label="Статус">{{$track->is_active?'Активен':'Скрыт'}}</td><td data-label=""><form method="post" action="{{route('admin.music.destroy',$track)}}">@csrf @method('DELETE')<button class="button danger">Удалить</button></form></td></tr>@empty<tr><td colspan="4">Пока нет треков.</td></tr>@endforelse</tbody></table></section>
@endsection