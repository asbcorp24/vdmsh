<?php
if(!function_exists('download_url')){function download_url(?string $path):string{return $path?route('download',['path'=>$path]):'#';}}
