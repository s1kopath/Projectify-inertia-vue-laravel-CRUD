<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    use HasFactory;
    protected $guarded = [];
    protected $appends = ['img'];

    public function getImgAttribute()
    {
        return $this->imageRecover($this->file_path);
    }

    protected function imageRecover($path)
    {
        if ($path == null || !\Illuminate\Support\Facades\Storage::disk('public')->exists($path)) {
            return 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQMX0FQrrMzh1hKS9zwUNx1-lzsZTk_GiJUvQ&s';
        }

        $storage_link = \Illuminate\Support\Facades\Storage::url($path);

        return asset($storage_link);
    }
}
