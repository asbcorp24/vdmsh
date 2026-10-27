<?php
use Illuminate\Database\Migrations\Migration;use Illuminate\Database\Schema\Blueprint;use Illuminate\Support\Facades\Schema;
return new class extends Migration{public function up():void{Schema::create('page_media',function(Blueprint $t){$t->foreignId('page_id')->constrained('pages')->cascadeOnDelete();$t->foreignId('media_id')->constrained('media')->cascadeOnDelete();$t->unsignedInteger('sort')->default(0);$t->primary(['page_id','media_id']);});}public function down():void{Schema::dropIfExists('page_media');}};
