<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;
return new class extends Migration{
 public function up():void{
  Schema::table('documents',fn(Blueprint $t)=>$t->foreignId('page_id')->nullable()->after('id')->constrained('pages')->nullOnDelete()->index());
  $titles=['Основные сведения','Структура и органы управления образовательной организацией','Документы','Образование','Руководство','Педагогический состав','Материально-техническое обеспечение и оснащенность образовательного процесса. Доступная среда','Платные образовательные услуги','Финансово-хозяйственная деятельность','Вакантные места для приема (перевода) обучающихся','Стипендии и меры поддержки обучающихся','Международное сотрудничество','Организация питания в образовательной организации'];
  foreach($titles as $i=>$title){$slug='svedeniya-'.Str::slug($title);if(!DB::table('pages')->where('slug',$slug)->exists())DB::table('pages')->insert(['title'=>$title,'slug'=>$slug,'section'=>'official','excerpt'=>'Официальная информация об образовательной организации.','content'=>'<p>Раздел готов для заполнения администратором сайта.</p>','meta_title'=>$title,'sort'=>($i+1)*10,'is_published'=>true,'template'=>'wide','created_at'=>now(),'updated_at'=>now()]);}
 }
 public function down():void{Schema::table('documents',fn(Blueprint $t)=>$t->dropConstrainedForeignId('page_id'));}
};