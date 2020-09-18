<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PostsController extends Controller
{
    public function __construct()
    { // Post'la ilgili yapılacak işlemler için auth isteyecek.
        $this->middleware('auth');
    }

    public function create()
    {
        return view('posts/create'); 
        // 1- Yaratacağımız view dosyası, controller fonksiyonuyla aynı isimde. 
        // 2- Klasör adıysa controller isminin ilk bölümüyle aynı.
        // 3- posts.create şeklinde de yazılabilirdi.
    }

    public function store()
    {
        $data = request()->validate([
            //'another' => '', // Eğer validation istemeyen bir girdimiz varsa ve aşağıdaki create metoduna yollayacksak büle oluyor.
            'caption' => 'required',
            'image' => ['required', 'image'], // image->resim dosyası kısıtlaması. 'required|image' şeklinde de yazılabilirdi.
        ]);

        $imagePath = request('image')->store('uploads', 'public'); 
        // uploads -> klasör, otomatik olarak oluşturuldu. 'public' -> driver. Local storage'ımız public klasörü

        // İlişki ile yaratmak
        // Giriş yapmış kullanıcıyı al, post'una git ve yarat/kaydet.
        auth()->user()->posts()->create([
            'caption' => $data['caption'],
            'image' => $imagePath,
        ]);        

        return redirect('/profile/' . auth()->user()->id);
    }
}
