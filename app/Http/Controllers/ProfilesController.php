<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Intervention\Image\Facades\Image;

class ProfilesController extends Controller
{
    public function index(User $user)
    {
        $follows = (auth()->user()) ? auth()->user()->following->contains($user->id) : false;

        // 'count.posts.'.$user->id -> Bir cache key oluşturduk. Bu bize her user için benzersiz bir key verecek.
        // use ($user) -> function() içinde $user'ı doğrudan kullanamadığımız için böyle verdik.
        // now()->addSeconds(30) -> Ne kada süre cache'de tutlacağı.
        $postCount = Cache::remember(
            'count.posts.' . $user->id,
            now()->addSeconds(30), 
            function() use ($user) {
                return $user->posts->count();
            });

        $followersCount = Cache::remember(
            'count.followers.' . $user->id,
            now()->addSeconds(30),
            function() use ($user) {
                return $user->profile->followers->count();
            });
        
        $followingCount = Cache::remember(
            'count.following.' . $user->id,
            now()->addSeconds(30),
            function() use ($user) {
                return $user->following->count();
            });        
       
        // 'profiles/index' -> resoruces/views/profiles/index.blade.php
        return view('profiles/index', compact('user', 'follows', 'postCount', 'followersCount', 'followingCount')); 
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
        
        // Kullanıcı her zaman resmini değiştirmek istemeyebilir. Eski resmi kalsın diye böyle yapıyoruz.
        // If request has an image...
        if(request('image')) {
            $imagePath = request('image')->store('profile', 'public');
            
            $image = Image::make(public_path("storage/{$imagePath}"))->fit(1000, 1000);
            $image->save();

            $imageArray = ['image' => $imagePath];
        }
        
        // auth() -> Güvenlik önlemi. Sadece giriş yapmış olan kullanıcının işlem yapmasına izin verir.
        // $imageArray ?? [] -> resim tanımlanmışsa $data içindeki 'image' key'ine sahip şeyi override edecek, tanımlanmamışsa etmeyecek
        // $imageArray sadece request'te image varsa oluşturulacak
        auth()->user()->profile->update(array_merge(
            $data,
            $imageArray ?? [],
        ));

        return redirect("/profile/{$user->id}");
    }
}
