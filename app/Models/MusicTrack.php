<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;use Illuminate\Support\Facades\Storage;
class MusicTrack extends Model{
 protected $fillable=['title','artist','file_path','file_name','mime_type','file_size','sort_order','is_active'];
 protected $casts=['is_active'=>'boolean'];
 public function getFileUrlAttribute(){return $this->file_path?Storage::disk('public')->url($this->file_path):null;}
 public function getHumanFileSizeAttribute(){if(!$this->file_size)return null;$u=['Б','КБ','МБ','ГБ'];$s=$this->file_size;$i=0;while($s>=1024&&$i<count($u)-1){$s/=1024;$i++;}return round($s,$i?1:0).' '.$u[$i];}
}