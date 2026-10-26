<?php
namespace Database\Seeders;
use App\Models\{Page,MenuItem};use Illuminate\Database\Seeder;use Illuminate\Support\Str;
class SiteStructureSeeder extends Seeder{
 public function run():void{
  $tree=[
   ['О школе',null,[['История школы','history'],['Руководство','management'],['Педагогический коллектив','teachers-info'],['Отделения школы','departments-info'],['Наши достижения','achievements-info'],['Материально-техническая база','facilities']]],
   ['Обучение',null,[['Образовательные программы','educational-programs'],['Правила приёма','admission-rules'],['Расписание занятий','schedule-info'],['Методическая работа','methodical-work'],['Платные образовательные услуги','paid-services']]],
   ['Ученикам и родителям',null,[['Информация для родителей','parents'],['Безопасность','safety'],['Профилактика и здоровье','prevention'],['Полезные ссылки','useful-links']]],
   ['Творческая жизнь',null,[['Концертная деятельность','concert-life'],['Конкурсы и фестивали','competitions-info'],['Творческие коллективы','collectives-info'],['Проекты школы','projects']]],
   ['Сведения об образовательной организации',null,[['Основные сведения','official-main'],['Структура и органы управления','official-structure'],['Документы','official-documents'],['Образование','official-education'],['Руководство и педагогический состав','official-staff'],['Материально-техническое обеспечение','official-material'],['Платные образовательные услуги','official-paid'],['Финансово-хозяйственная деятельность','official-finance'],['Вакантные места для приёма','official-vacancies'],['Стипендии и меры поддержки','official-support'],['Доступная среда','official-accessibility'],['Международное сотрудничество','official-international'],['Организация питания','official-food']]],
   ['Обращения и открытость',null,[['Обратная связь','feedback'],['Независимая оценка качества','independent-assessment'],['Противодействие коррупции','anti-corruption'],['Политика обработки персональных данных','privacy']]],
  ];
  foreach($tree as $rootIndex=>$root){
   $rootPage=$this->page($root[0],Str::slug($root[0]),null,$rootIndex*10);
   $rootMenu=$this->menu($root[0],$rootPage,null,$rootIndex*10);
   foreach($root[2] as $i=>$child){$p=$this->page($child[0],$child[1],$rootPage->id,$i*10);$this->menu($child[0],$p,$rootMenu->id,$i*10);}
  }
  $special=[['Новости','/news'],['Афиша','/events'],['Фотогалерея','/gallery'],['Контакты','/contacts']];
  foreach($special as $i=>$x)MenuItem::updateOrCreate(['location'=>'main','title'=>$x[0]],['url'=>$x[1],'sort'=>100+$i*10,'is_active'=>true,'target'=>'_self']);
 }
 private function page(string $title,string $slug,?int $parent,int $sort):Page{return Page::updateOrCreate(['slug'=>$slug],['parent_id'=>$parent,'title'=>$title,'section'=>'information','template'=>'default','excerpt'=>'Информационный раздел Детской школы искусств г. Волжска.','content'=>'<p>Раздел подготовлен для размещения актуальной информации. Содержание можно изменить в административной панели.</p>','meta_title'=>$title.' — ДШИ г. Волжска','meta_description'=>$title.'. Официальная информация Детской школы искусств г. Волжска.','sort'=>$sort,'is_published'=>true]);}
 private function menu(string $title,Page $page,?int $parent,int $sort):MenuItem{return MenuItem::updateOrCreate(['location'=>'main','page_id'=>$page->id],['parent_id'=>$parent,'title'=>$title,'sort'=>$sort,'is_active'=>true,'target'=>'_self']);}
}