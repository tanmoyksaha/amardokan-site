@extends('main.header-footer')

@section('main_content')

<section class="main_content">
    <div class="container">
        <div class="mb-4">
            @php $url=env('SELLER_PANEL') @endphp
            <a href="{{ $url }}">
                @php $url=env('SITE_URL')."assets/sellOnAmardokan/login.jpg"; @endphp
                <img src="{{ $url }}" class="img-fluid">
            </a>
        </div>
        <div class="mb-4">
            @php $url=env('SELLER_PANEL')."store-reg-form" @endphp
            <a href="{{$url}}">
                @php $url=env('SITE_URL')."assets/sellOnAmardokan/signUp.jpg"; @endphp
                <img src="{{ $url }}" class="img-fluid">
            </a>
        </div>
    </div>
</section>
    
@endsection
