<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Profile extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function user() // İsimlendirme önemli, sınıf ismyile aynı olmalı.
    {
        return $this->belongsTo(User::class);
    }
}
