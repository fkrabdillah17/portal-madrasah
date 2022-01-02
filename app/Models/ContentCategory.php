<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ContentCategory extends Model
{

    protected $guarded = ['id'];
    use HasFactory;

    public function categoryAcademic()
    {
        return $this->hasMany(Academic::class, 'tag', 'id');
    }
    public function categoryKesiswaan()
    {
        return $this->hasMany(Kesiswaan::class, 'tag', 'id');
    }
}
