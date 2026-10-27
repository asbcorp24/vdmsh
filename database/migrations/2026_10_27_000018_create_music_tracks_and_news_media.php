<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
return new class extends Migration{
 public function up():void{
  if(!Schema::hasTable('music_tracks'))Schema::create('music_tracks',function(Blueprint $t){$t->id();$t->string('title');$t->string('artist')->nullable();$t->string('file_path');$t->string('file_name')->nullable();$t->string('mime_type',100)->nullable();$t->unsignedBigInteger('file_size')->default(0);$t->unsignedInteger('sort_order')->default(0);$t->boolean('is_active')->default(true);$t->timestamps();});
  if(!Schema::hasTable('news_media'))Schema::create('news_media',function(Blueprint $t){$t->foreignId('news_id')->constrained()->cascadeOnDelete();$t->foreignId('media_id')->constrained('media')->cascadeOnDelete();$t->unsignedInteger('sort')->default(0);$t->primary(['news_id','media_id']);});
 }
 public function down():void{Schema::dropIfExists('news_media');Schema::dropIfExists('music_tracks');}
};