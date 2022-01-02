<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class News extends Model
{
    protected $guarded = ['id'];
    protected $dates = ['published_at'];
    const EXCERPT_LENGTH = 300;
    use HasFactory;

    public function createBy()
    {
        return $this->belongsTo(User::class, 'createdBy', 'id');
    }
    public function updateBy()
    {
        return $this->belongsTo(User::class, 'updatedBy', 'id');
    }
    public function newsCategory()
    {
        return $this->hasone(Category::class, 'id', 'category_id');
    }
}
