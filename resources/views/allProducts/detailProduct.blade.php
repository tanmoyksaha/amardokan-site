@extends('main.header-footer')
@section('css')

    <!-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.2/css/bootstrap.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.25/css/dataTables.bootstrap4.min.css"> -->

    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.4/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.2/css/bootstrap.css">
      
@endsection
@section('main_content')

<section class="main_content">
    <!--breadcrumbs area start-->
    <div class="breadcrumbs_area">
            <div class="container">   
                <div class="row">
                    <div class="col-12">
                        <div class="breadcrumb_content text-light">
                            <h3><b>{{ $productsDetails[0]->product_name }}</b></h3>
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
                                <img id="zoom1" src="{{ env('ADMIN_PANEL').'images/products/'.$pId.'-1.jpg' }}" data-zoom-image="{{ env('ADMIN_PANEL').'images/products/'.$pId.'-1.jpg' }}" alt="big-1">
                            </a>
                        </div>
                    </div>
                    <div>
                        <h1 class="p-2"><a href="#">{{ $productsDetails[0]->product_name }}</a></h1>
                        <div class="product_desc py-2">
                            @if($productsDetails[0]->product_description!=null)
                            <p>{{ $productsDetails[0]->product_description }}</p>
                            @endif
                        </div>
                        @if($productsDetails[0]->product_category!=null)
                        <div class="product_meta">
                            <span>Category: <a href="#">{{ $productsDetails[0]->product_category }}</a></span>
                        </div>
                        @endif
                        @if($productsDetails[0]->product_sub_category!=null)
                        <div class="product_meta">
                            <span>Sub Category: <a href="#">{{ $productsDetails[0]->product_sub_category }}</a></span>
                        </div>
                        @endif
                    </div>
                </div>
                <div class="col-lg-7 col-md-7">
                    <div class="product_d_right">
                        <div class="card">
                            <div class="card-header">
                                <div class="row">
                                    <div class="col-lg-5 m-auto">
                                        <span class="h4">Shops & Prices</span>
                                    </div>
                                    <div class="col-lg-7">
                                        <div class="search_box search_five mobail_s_none bg-white">
                                            <form action="#">
                                                <input placeholder="District, Delivery Area, Shop Name" type="text">
                                                <button type="submit"><span class="lnr lnr-magnifier"></span></button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @if(session('error'))
                            <div class="alert alert-danger text-center text-weight-bold h5" role="alert">
                                {{ session('error') }}
                            </div>
                            @endif
                            <div class="card-body">
                                <table id="shopPriceList" class="table display nowrap  table-striped table-bordered text-center" style="width:100%">
                                    <thead>
                                        <tr>
                                            <th>Logo</th>
                                            <th>Shop Name</th>
                                            <th>District</th>
                                            <th>Delivery Area</th>
                                            <th>Price</th>
                                            <th>Order Type</th>
                                            <th>Add to Cart</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($shops as $shop)
                                        <tr>
                                            <td style="width: 200px;">
                                                <img src="{{ env('ADMIN_PANEL').'images/shop_banner/'.$shop->id.'.png' }}"  class="img-fluid" alt="" srcset="">
                                            </td>
                                            <td style="width: 100px;">{{ $shop->shop_name }}</td>
                                            <td style="width: 100px;">{{ $shop->district }}</td>
                                            <td style="width: 100px;">{{ $shop->del_area }}</td>
                                            <td>
                                                <div class="price_box"> 
                                                    <span class="current_price">৳{{ $shop->sale_price }}</span>
                                                    <span class="old_price">৳{{ $shop->unit_mrp }}</span>
                                                </div>
                                            </td>
                                            <td>
                                                @if($shops[0]->stock>1)
                                                <div class="price_box"> 
                                                    <span class="current_price font-weight-bold" style="font-size: 100%;">Available for Delivery</span>
                                                </div>
                                                @else
                                                <div class="price_box"> 
                                                    <span class="current_price font-weight-bold" style="font-size: 100%;">Only for Preorder</span>
                                                </div>
                                                @endif
                                            </td>
                                            <td style="width: 111px;">
                                                <div class="product_content grid_content pb-3">
                                                    <form action="{{ route('gen-add-to-cart')}}" method="post">
                                                        @csrf
                                                        <input type="hidden" value="{{$shops[0]->store_p_id}}" name="gen_p_id">
                                                        <input type="hidden" value="1" name="pQty">
                                                        <button type="submit" id="27_addToCart" class="add-to-cart btn add-to-cart-btn">
                                                            <i class="bi bi-cart-plus"></i>
                                                        </button>
                                                    </form>
                                                </div>
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>    
    </div>
    <!--product details end-->
        
    <!--product info start-->
    <div class="product_d_info mb-65">
        @if($productsDetails[0]->product_description!=null) 
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
                                    <p>{{ $productsDetails[0]->product_description }}</p>
                                </div>    
                            </div>
                        </div>
                       
                    </div>     
                </div>
            </div>
        </div>  
        @endif   
    </div>  
    <!--product info end-->
</section>

@endsection
@section('js')
    <!-- <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
    <script src="https://cdn.datatables.net/1.10.25/js/jquery.dataTables.min.js"></script>

    <script src="https://cdn.datatables.net/1.10.25/js/dataTables.bootstrap4.min.js"></script> -->

    <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
    <script src="https://cdn.datatables.net/1.11.4/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.4/js/dataTables.bootstrap4.min.js"></script>

    <script>
        $(document).ready(function() {
            $('#shopPriceList').DataTable({
                searching: false, 
                paging: false, 
                info: false,
                "ordering": true
            });
        });
    </script>
@endsection



        