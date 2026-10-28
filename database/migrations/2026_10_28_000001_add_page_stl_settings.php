<?php
use Illuminate\Database\Migrations\Migration;use Illuminate\Database\Schema\Blueprint;use Illuminate\Support\Facades\Schema;
return new class extends Migration{public function up():void{Schema::table('pages',function(Blueprint $t){$t->float('stl_rot_x')->default(0);$t->float('stl_rot_y')->default(0);$t->float('stl_rot_z')->default(0);$t->float('stl_zoom')->default(1);$t->string('stl_color',7)->default('#d9b36c');});}public function down():void{Schema::table('pages',function(Blueprint $t){$t->dropColumn(['stl_rot_x','stl_rot_y','stl_rot_z','stl_zoom','stl_color']);});}};
