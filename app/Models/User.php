<?php

namespace App\Models;

use Illuminate\Support\Facades\Mail;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use App\Mail\NewUserWelcomeMail;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'username', 'password', 
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    protected static function boot()
    {
        parent::boot();

        // override ediyoruz;
        // created() event'i her user yaratıldığında tetiklenecek.
        // profiles talosundaki tüm alanlar nullable olduğu için 'title' => $user->username yazmamıza gerek yoktu ama profil bomboş kalmasın deyu yazdık.
        static::created(function($user) {
            $user->profile()->create([
                'title' => $user->username,
            ]);
            

            Mail::to($user->email)->send(new NewUserWelcomeMail());
        });
    }

    public function posts()     // s ekine dikkat! çoğul. Öünkü 1:m ilişki var.
    {
        return $this->hasMany(Post::class)->orderBy('created_at', 'DESC');
    }

    // User birden çok kullanıcı takip edebilir.
    // m:n ilişki
    public function following()
    {
        return $this->belongsToMany(Profile::class);
    }

    // 1:1 ilişki
    public function profile()   
    {
        return $this->hasOne(Profile::class);
    }
}
