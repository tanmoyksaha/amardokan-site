@extends('main.header-footer')

@section('main_content')

<section class="main_content">
        <!--slider area start-->
    <section class="slider_section slider_s_five mb-10">
        @include("home.slider")
    </section>
    <!--slider area end-->

    <!--banner area start-->
    <div class="banner_area">
        @include("home.promoBanner")
    </div>
    <!--banner area end-->

    <!--home three bg area start-->   
    <div class="container">
        @include("home.shopSearchBox")
    </div>
    <!--home three bg area end--> 

    
    <!-- ShopList -->    
    <div class="container mb-30">
        @include("home.shopList")
    </div>
</section>
    
@endsection
