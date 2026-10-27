<?php
namespace App\Models;use Illuminate\Database\Eloquent\Model;
class Event extends Model{
 protected $fillable=['title','slug','description','place','cover','starts_at','ends_at','is_published'];
 protected $casts=['starts_at'=>'datetime','ends_at'=>'datetime','is_published'=>'boolean'];
 public function performances(){return $this->hasMany(EventPerformance::class)->where('is_published',true)->orderBy('program_number')->orderBy('id');}
 public function allPerformances(){return $this->hasMany(EventPerformance::class)->orderBy('program_number')->orderBy('id');}
 public function scopePublished($q){return $q->where('is_published',true);}
 public function scopeUpcoming($q){return $q->where('starts_at','>=',now()->startOfDay());}
 public function scopePast($q){return $q->where('starts_at','<',now()->startOfDay());}
}