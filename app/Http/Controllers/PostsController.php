<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use Intervention\Image\Facades\Image; // Image Intervention kütüphanesini kullanabilmek için eklendi

class PostsController extends Controller
{
    // Post'la ilgili yapılacak işlemler için auth isteyecek.
    public function __construct()
    { 
        $this->middleware('auth');
    }

    public function index()
    {
        // Gönderiler doğrudan profile değilde user'a bağlı oldukları için...
        // pluck('profiles.user_id') -> Takip edilen user_id'leri verecek.
        // $users -> Giriş yapmış olan kullanıcnın takip ettiği user'ların id'si
        $users = auth()->user()->following()->pluck('profiles.user_id');

        // whereIn() -> dizi geçireceğimiz için. where user_id is in $users
        // latest() -> Yaratılma tarihine göre sondan başa doğru sıralayacak. Bunun yerine orderBy('created_at', 'DESC') de kullanabilirdik
        // with('user') -> N+1 problemini çözmek için
        $posts = Post::whereIn('user_id', $users)->with('user')->latest()->paginate(5);
       

        return view('posts/index', compact('posts'));
    }

    // 1- Yaratacağımız view dosyası, controller fonksiyonuyla aynı isimde. 
    // 2- Klasör adıysa controller isminin ilk bölümüyle aynı.
    // 3- posts.create şeklinde de yazılabilirdi.
    public function create()
    {
        return view('posts/create');         
    }

    public function store()
    {
        // image -> resim dosyası kısıtlaması. 'required|image' şeklinde de yazılabilirdi.
        // 'another' => '' -> Eğer validation istemeyen bir girdimiz varsa ve aşağıdaki create metoduna yollayacksak büle oluyor.
        $data = request()->validate([
            //'another' => '',
            'caption' => 'required',
            'image' => ['required', 'image'], 
        ]);

        // uploads -> klasör, otomatik olarak oluşturuldu. 'public' -> driver. Local storage'ımız public klasörü
        $imagePath = request('image')->store('uploads', 'public'); 
        

        // Resim manüpülasyonu
        // make() -> Biçimlendirebilmemiz için resim dosyasımızı Intervention sınıfına sarar
        // fit() -> resize'dan farklı, resmi boyutlandırmaz kırpar.
        $image = Image::make(public_path("storage/{$imagePath}"))->fit(1200, 1200);
        $image->save();
        

        // İlişki ile yaratmak
        // Giriş yapmış kullanıcıyı al, post'una git ve yarat/kaydet.
        auth()->user()->posts()->create([
            'caption' => $data['caption'],
            'image' => $imagePath,
        ]);        

        return redirect('/profile/' . auth()->user()->id);
    }

    public function show(\App\Models\Post $post)
    {
        // compact('post') -> dizi ile -['post' => $post,]- $post'u geçirmek yerine kısaca böyle çektik. Aynı şey
        return view('posts/show', compact('post'));
    }
}
