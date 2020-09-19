<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class ProfilesController extends Controller
{
    public function index(User $user)
    {
        // 'profiles/index' -> resoruces/views/profiles/index.blade.php
        return view('profiles/index', compact('user')); 
    }

    public function edit(User $user)
    {
        $this->authorize('update', $user->profile);

        return view('profiles/edit', compact('user'));
    }

    public function update(User $user)
    {
        $this->authorize('update', $user->profile);
        
        // 'url' -> url mi diye kontrol ediyor.        
        $data = request()->validate([
            'title' => 'required',
            'description' => 'required',
            'url' => 'url',
            'image' => '',
        ]);

        // auth() -> Güvenlik önlemi. Sadece giriş yapmış olan kullanıcının işlem yapmasına izin verir.
        auth()->user()->profile->update($data);

        return redirect("/profile/{$user->id}");
    }
}
