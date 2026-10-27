<?php
namespace App\Models;use Illuminate\Database\Eloquent\Model;
class MusicComposition extends Model{protected $fillable=['title','composer','performer','instrument','description','audio_file','cover','sort','is_published'];protected $casts=['is_published'=>'boolean'];}