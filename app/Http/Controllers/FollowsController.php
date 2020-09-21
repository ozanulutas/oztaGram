<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class FollowsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    // Giriş yapmış kullanıcıyı alıp bu ilişkiye eklemeli(attach) veya çıkarmalaıyız(detach)
    // toggle() -> Toggles between connected or not connected. follow'unfollow
    // $user, giriş yapmış olan user değil de parametre olarak geçen $user
    public function store(User $user)
    {    
        // authenticated user'ı al, following ilişkisini çağır ve toggle() metodunu çalıştır.
        // User'ın profile'ını toggle'lıyoruz.   
        return auth()->user()->following()->toggle($user->profile);
        
    }
}
