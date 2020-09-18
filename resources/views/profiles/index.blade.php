@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-3 p-4">
            <img src="https://scontent-otp1-1.cdninstagram.com/v/t51.2885-19/s150x150/97566921_2973768799380412_5562195854791540736_n.jpg?_nc_ht=scontent-otp1-1.cdninstagram.com&_nc_ohc=qiV3FxOiW5cAX9Tmvec&oh=5cd9b2361e4f06871bdcc84ee878e8c4&oe=5F8A0AE7" 
            class="rounded-circle">
        </div>

        <div class="col-9 pt-4">
            <div class="d-flex justify-content-between align-items-baseline">
                <h1>{{ $user->username }}</h1>
                <a href="#" >Add New Post</a>
            </div>
            <div class="d-flex">
                <div class="pr-5"> <strong>153</strong> posts</div>
                <div class="pr-5"> <strong>23k</strong> followers</div>
                <div class="pr-5"> <strong>212</strong> following</div>
            </div>
            <div class="pt-4 font-weight-bold">{{ $user->profile->title }}</div>
            <div>{{ $user->profile->description }}</div>
            <div><a href="#">{{ $user->profile->url }}</a></div>
        </div>
    </div>

    <div class="row pt-5">
        <div class="col-4">
            <img src="https://scontent-otp1-1.cdninstagram.com/v/t51.2885-15/sh0.08/e35/c2.0.746.746a/s640x640/116362545_618124912453256_2781481867424758391_n.jpg?_nc_ht=scontent-otp1-1.cdninstagram.com&_nc_cat=108&_nc_ohc=KhDFkPBBcK0AX-bgXAS&oh=d08a62c3cabd10dd21966a9d98812105&oe=5F8D47EA" class="w-100">
        </div>
        <div class="col-4">
            <img src="https://scontent-otp1-1.cdninstagram.com/v/t51.2885-15/sh0.08/e35/c0.117.937.937a/s640x640/116792589_940704333073490_3603561987847571728_n.jpg?_nc_ht=scontent-otp1-1.cdninstagram.com&_nc_cat=102&_nc_ohc=92EFmNr20WcAX-G8BO5&oh=1313d7c8b65ebafdb7078f63702478cb&oe=5F8BE733" class="w-100">
        </div>
        <div class="col-4">
            <img src="https://scontent-otp1-1.cdninstagram.com/v/t51.2885-15/sh0.08/e35/c2.0.746.746a/s640x640/116046434_2514443215325780_2721033236601132108_n.jpg?_nc_ht=scontent-otp1-1.cdninstagram.com&_nc_cat=108&_nc_ohc=jIIW_4pItN0AX9egIRW&oh=0dfd5c735438ee8055886e66a4fabbde&oe=5F8C4ED1" class="w-100">
        </div>
        
    </div>
</div>

@endsection
