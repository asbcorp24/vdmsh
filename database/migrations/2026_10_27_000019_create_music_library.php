<?php
use Illuminate\Database\Migrations\Migration;use Illuminate\Database\Schema\Blueprint;use Illuminate\Support\Facades\{Schema,DB};
return new class extends Migration{
 public function up():void{
  if(!Schema::hasTable('music_compositions'))Schema::create('music_compositions',function(Blueprint $t){$t->id();$t->string('title');$t->string('composer')->nullable()->index();$t->string('performer')->nullable();$t->string('instrument')->nullable()->index();$t->text('description')->nullable();$t->string('audio_file');$t->string('cover')->nullable();$t->unsignedInteger('sort')->default(0);$t->boolean('is_published')->default(true)->index();$t->timestamps();});
  if(!Schema::hasTable('sheet_music'))Schema::create('sheet_music',function(Blueprint $t){$t->id();$t->string('title');$t->string('composer')->nullable()->index();$t->string('instrument')->nullable()->index();$t->string('level')->nullable()->index();$t->text('description')->nullable();$t->string('file');$t->string('preview')->nullable();$t->unsignedInteger('sort')->default(0);$t->boolean('is_published')->default(true)->index();$t->timestamps();});
  if(Schema::hasTable('menu_items')&&!DB::table('menu_items')->where('url','/music-library')->exists())DB::table('menu_items')->insert(['title'=>'Музыка и ноты','url'=>'/music-library','location'=>'main','target'=>'_self','sort'=>65,'is_active'=>1,'created_at'=>now(),'updated_at'=>now()]);
 }
 public function down():void{if(Schema::hasTable('menu_items'))DB::table('menu_items')->where('url','/music-library')->delete();Schema::dropIfExists('sheet_music');Schema::dropIfExists('music_compositions');}
};