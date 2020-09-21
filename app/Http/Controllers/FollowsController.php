<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class FollowsController extends Controller
{
    // Giriş yapmış kullanıcıyı alıp bu ilişkiye eklemeli(attach) veya çıkarmalaıyız(detach)
    // toggle() -> follow'unfollow
    public function store(User $user)
    {       
        return auth()->user()->following()->toggle($user->profile);
        // $user, giriş yapmış olan user değil de parametre olarak geçen $user
    }
}
