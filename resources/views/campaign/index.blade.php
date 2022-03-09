@extends('main.header-footer')

@section('main_content')

<section class="main_content">
    <!--breadcrumbs area start-->
    <div class="breadcrumbs_area">
        <div class="container">   
            <div class="row">
                <div class="col-12">
                    <div class="breadcrumb_content text-light">
                        <h3 >{{ $campaignName }}</h3>
                    </div>
                </div>
            </div>
        </div>         
    </div>
    <!--breadcrumbs area end-->

    <!--home three bg area start-->   
    <div class="container mt-4">
        @include("campaign.campaignSearchBox")
    </div>
    <!--home three bg area end--> 

    <!-- ShopList -->    
    <div class="container mb-30">
        @include("campaign.shopList")
    </div>
</section>
    
@endsection
