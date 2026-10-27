<?php
namespace App\Models;use Illuminate\Database\Eloquent\Model;
class SheetMusic extends Model{protected $table='sheet_music';protected $fillable=['title','composer','instrument','level','description','file','preview','sort','is_published'];protected $casts=['is_published'=>'boolean'];}