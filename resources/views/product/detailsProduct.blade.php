@extends('main.header-footer')

@section('main_content')

<section class="main_content">
    <!--breadcrumbs area start-->
    <div class="breadcrumbs_area">
            <div class="container">   
                <div class="row">
                    <div class="col-12">
                        <div class="breadcrumb_content text-light">
                            <h3 >{{ $shopName[0]->shop_name }}</h3>
                        </div>
                    </div>
                </div>
            </div>         
        </div>
        <!--breadcrumbs area end-->
    <!--product details start-->
    <div class="product_details mt-70 mb-70">
            <div class="container">
                <div class="row">
                    <div class="col-lg-5 col-md-5">
                        <div class="product-details-tab">
                            <div id="img-1" class="zoomWrapper single-zoom">
                                <a href="#">
                                    <img id="zoom1" src="{{ env('ADMIN_PANEL').'images/products/'.$products[0]->product_id.'-1.jpg' }}" data-zoom-image="{{ env('ADMIN_PANEL').'images/products/'.$products[0]->product_id.'-1.jpg' }}" alt="big-1">
                                </a>
                            </div>
                            <div class="single-zoom-thumb">
                                <ul class="s-tab-zoom owl-carousel single-product-active" id="gallery_01">
                                    <li>
                                        <a href="#" class="elevatezoom-gallery active zoomGalleryActive" data-update="" data-image="{{ env('ADMIN_PANEL').'images/products/'.$products[0]->product_id.'-1.jpg' }}" data-zoom-image="{{ env('ADMIN_PANEL').'images/products/'.$products[0]->product_id.'-1.jpg' }}">
                                            <img src="{{ env('ADMIN_PANEL').'images/products/'.$products[0]->product_id.'-1.jpg' }}" alt="zo-th-1"/>
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-7 col-md-7">
                        <div class="product_d_right">
                            <form action="{{ route('gen-add-to-cart')}}" method="post">
                                @csrf
                                <input type="hidden" name="gen_p_id" value="{{$products[0]->store_p_id}}">
                                <h1><a href="#">{{ $products[0]->product_name }}</a></h1>
                                <div class="price_box">
                                    <span class="current_price">৳{{ $products[0]->sale_price }}</span>
                                    @if($products[0]->sale_price!=$products[0]->unit_mrp)
                                    <span class="old_price">৳{{ $products[0]->unit_mrp }}</span>
                                    @endif
                                </div>
                                <div class="product_desc">
                                    <p>
                                        {{ $products[0]->product_description }}
                                    </p>
                                </div>
                                @if($products[0]->stock>1)
                                <div class="price_box"> 
                                    <span class="current_price font-weight-bold">Available for Delivery</span>
                                </div>
                                @else
                                <div class="price_box"> 
                                    <span class="current_price font-weight-bold">Only for Preorder</span>
                                </div>
                                @endif
                                <div class="product_variant quantity">
                                    <label>quantity</label>
                                    <input name="pQty" min="1" max="100" value="1" type="number">
                                    <button class="button" type="submit">add to cart</button>  
                                </div>
                                <!-- <div class="product_meta">
                                    <span>Category: <a href="#">Clothing</a></span>
                                </div> -->
                                
                            </form>
                            <div class="priduct_social">
                                <ul>
                                    
                                    <li><a class="facebook" href="https://www.facebook.com/sharer/sharer.php?u={{url()->current()}}" title="facebook"><i class="fa fa-facebook"></i> Share</a></li>               
                                </ul>      
                            </div>

                        </div>
                    </div>
                </div>
            </div>    
        </div>
        <!--product details end-->
        
        <!--product info start-->
        <div class="product_d_info mb-65">
            <div class="container">   
                <div class="row">
                    <div class="col-12">
                        <div class="product_d_inner">   
                            <div class="product_info_button">    
                                <ul class="nav" role="tablist" id="nav-tab">
                                    <li >
                                        <a class="active" data-toggle="tab" href="#info" role="tab" aria-controls="info" aria-selected="false">Description</a>
                                    </li>
                                </ul>
                            </div>
                            <div class="tab-content">
                                <div class="tab-pane fade show active" id="info" role="tabpanel" >
                                    <div class="product_info_content">
                                        <p>
                                            {{ $products[0]->product_description }}
                                        </p>
                                    </div>    
                                </div>
                            </div>
                        </div>     
                    </div>
                </div>
            </div>    
        </div>  
        <!--product info end-->
    </div>
</section>

@endsection



        