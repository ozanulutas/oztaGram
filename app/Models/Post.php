<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;

    protected $guarded = []; // Veritabanına veri giişine izin vermek için $guarded'ı override ettik. Normalde default olarak kapalı.

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
