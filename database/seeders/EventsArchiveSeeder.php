<?php
namespace Database\Seeders;
use App\Models\Event;use Illuminate\Database\Seeder;
class EventsArchiveSeeder extends Seeder{
 public function run():void{
  $events=[
   ['palantay-tour-2026','Тур конкурса им. М. И. Ключникова-Палантая','2026-03-18 12:00:00','Детская школа искусств г. Волжска'],
   ['zhavaronok-2026','«Звонче жаворонка пение»','2026-03-25 12:00:00','Корпус № 3'],
   ['na-klavishah-vesny-2026','«На клавишах весны»','2026-04-02 12:00:00','Детская школа искусств г. Волжска'],
   ['v-siyanii-muzyki-i-krasok-2026','Отчётный концерт «В сиянии музыки и красок»','2026-04-24 12:00:00','Корпус № 3'],
   ['spoem-horom-2026','Фестиваль «Споём хором!»','2026-04-25 12:00:00','Корпус № 3'],
   ['volshebnye-zvuki-royalya-2026','Отчётный концерт «Волшебные звуки рояля»','2026-05-14 12:00:00','Детская школа искусств г. Волжска'],
   ['vecher-fortepiannoy-muzyki-2026','Вечер фортепианной музыки','2026-05-28 12:00:00','Детская школа искусств г. Волжска'],
   ['vypusknoy-vecher-2026','Выпускной вечер-2026','2026-06-03 12:00:00','Корпус № 3'],
  ];
  foreach($events as [$slug,$title,$date,$place])Event::updateOrCreate(['slug'=>$slug],['title'=>$title,'starts_at'=>$date,'place'=>$place,'description'=>'Архивное событие школы. Точное время и подробное описание следует дополнить в административной панели по исходному материалу.','is_published'=>true]);
 }
}