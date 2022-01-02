<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Profile extends Model
{
    protected $guarded = ['id'];
    use HasFactory;

    public function createBy()
    {
        return $this->belongsTo(User::class, 'createdBy', 'id');
    }
    public function updateBy()
    {
        return $this->belongsTo(User::class, 'updatedBy', 'id');
    }

    public function category()
    {
        return $this->belongsTo(ContentCategory::class, 'tag', 'id');
    }
}
