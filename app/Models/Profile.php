<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Profile extends Model
{
    use HasFactory;

    protected $guarded = [];

    // Model içinde olduğumuz için alanlara direk $this ile erişebiliriz.
    public function profileImage()
    {
        $imagePath = ($this->image) ? $this->image : 'profile/065d8abNnlbdVgBfzZ1RtjvNbnrkySqGVRa3oQ7K.png'; 
        return '/storage/' . $imagePath;
    }

    // Bir profilin birden çok kullanıcı takipçisi olabilir
    // m:n ilişki
    public function followers()
    {
        return $this->belongsToMany(User::class);
    }

    // İsimlendirme önemli, sınıf ismyile aynı olmalı.
    // 1:1 ilişki
    public function user() 
    {
        return $this->belongsTo(User::class);
    }
}
