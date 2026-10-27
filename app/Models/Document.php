<?php
namespace App\Models;use Illuminate\Database\Eloquent\Model;
class Document extends Model{
 public const CATEGORIES=['Основные сведения','Структура и органы управления','Документы','Образование','Руководство и педагогический состав','Материально-техническое обеспечение','Платные образовательные услуги','Финансово-хозяйственная деятельность','Вакантные места для приёма','Стипендии и меры поддержки','Доступная среда','Международное сотрудничество','Организация питания','Приём в школу','Противодействие коррупции','Персональные данные','Независимая оценка качества'];
 protected $fillable=['page_id','title','description','number','document_date','category','file','published_at','sort','is_published'];
 protected $casts=['document_date'=>'date','published_at'=>'datetime','is_published'=>'boolean'];
 public function page(){return $this->belongsTo(Page::class);}
 public function getExtensionAttribute():string{return strtoupper(pathinfo((string)$this->file,PATHINFO_EXTENSION));}
}