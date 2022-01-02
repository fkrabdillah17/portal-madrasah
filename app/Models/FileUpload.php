<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FileUpload extends Model
{
    use HasFactory;
    protected $table = 'file_uploads';
    protected $guarded = ['id'];

    public function created_by()
    {
        return $this->belongsTo(User::class, 'created_by', 'id');
    }
}
