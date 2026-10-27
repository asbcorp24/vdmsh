<?php
namespace App\Http\Controllers;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
class DownloadController extends Controller{
 public function __invoke(string $path):BinaryFileResponse{
  $path=rawurldecode($path);
  abort_if(str_contains($path,'..')||str_starts_with($path,'/'),404);
  $disk=Storage::disk('public');abort_unless($disk->exists($path),404);
  $base=basename($path);$name=preg_replace('/[^\pL\pN._ -]+/u','_', $base) ?: 'download';
  return response()->download($disk->path($path),$name,['X-Content-Type-Options'=>'nosniff']);
 }
}