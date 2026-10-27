<?php
namespace App\Models;use Illuminate\Database\Eloquent\Model;
class EventPerformanceGuest extends Model{protected $fillable=['event_performance_id','name','role','organization','sort'];public function performance(){return $this->belongsTo(EventPerformance::class,'event_performance_id');}}