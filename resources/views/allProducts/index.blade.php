@extends('main.header-footer')

@section('main_content')
<section class="main_content">

    <!--breadcrumbs area start-->
    <div class="breadcrumbs_area">
        <div class="container">   
            <div class="row">
                <div class="col-12">
                    <div class="breadcrumb_content text-light">
                        <h3><b>All Products</b></h3>
                        @if(isset($shopName[0]->shop_name))
                        <h4><b>{{ $shopName[0]->shop_name }}</b></h4>
                        @endif
                    </div>
                </div>
            </div>
        </div>         
    </div>
    <!--breadcrumbs area end-->
    
    <!--shop  area start-->
    <div class="shop_area mt-30 mb-70">
        <div class="container">
            <div class="row">
                <div class="col-12 col-md-12">
                    <!--shop toolbar start-->
                    <div class="shop_toolbar_wrapper">
                        <div class=" niceselect_option">
                            <form class="select_option" action="#">
                                <select name="orderby" id="short">

                                    <option value="1">Sort by price: low to high</option>
                                    <option value="2">Sort by price: high to low</option>
                                </select>
                            </form>
                        </div>
                        <div class="page_amount">
                            <div class="col-12 ">
                                <div class="search_box search_five mobail_s_none">
                                    <form action="#">
                                        <input placeholder="Search here..." type="text">
                                        <button type="submit"><span class="lnr lnr-magnifier"></span></button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!--shop toolbar end-->
                    <div class="col-lg-12 col-md-12">
                        <!--shop toolbar end-->
                        <!-- Modal -->
                        <form>
                            @csrf
                            @if(session('error'))
                            <input type="hidden" id="cartErrorInput" value="1">
                            @endif
                        </form>
                        <div class="modal fade bd-example-modal-lg center" id="showErrorModal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
                            <div class="modal-dialog modal-lg ">
                                <div class="modal-content bg-danger text-center text-white p-4">
                                    {{ session('error') }}
                                </div>
                            </div>
                        </div>
                        <div class="row shop_wrapper">
                            @foreach($products as $product)
                                <div class="col-lg-2 col-md-2 col-sm-6 col-6  p-2">
                                    <form action="{{ route('gen-add-to-cart')}}" method="post">
                                        @csrf
                                        <input type="hidden" name="gen_p_id" value="{{$product->store_p_id}}">
                                        <div class="single_product shadow-sm">
                                            <div class="product_thumb">
                                                <a class="primary_img" href="singleProduct.php">
                                                    <img src="{{ env('ADMIN_PANEL').'images/products/'.$product->product_id.'-1.jpg' }}" alt="">
                                                </a>
                                                <!-- <div class="label_product">
                                                    <span class="label_sale">Sale</span>
                                                    <span class="label_new">New</span>
                                                </div> -->
                                            </div>
                                            <div class="product_content grid_content">
                                                <a href="singleProduct.php">
                                                    <h4 class="product_name">{{ $product->product_name }}</h4>
                                                </a>
                                                <div class="price_box"> 
                                                    <span class="current_price">৳{{ $product->sale_price }}</span>
                                                    <span class="old_price">৳{{ $product->unit_mrp }}</span>
                                                </div>
                                                <!-- @if($product->stock>1)
                                                <div class="price_box"> 
                                                    <span class="current_price font-weight-bold">Available for Delivery</span>
                                                </div>
                                                @else
                                                <div class="price_box"> 
                                                    <span class="current_price font-weight-bold">Only for Preorder</span>
                                                </div>
                                                @endif -->
                                            </div>
                                            <!-- <div class="product_content grid_content ">
                                                <div class="input-group px-4">
                                                    <div class="input-group-prepend">
                                                        <a id="{{$product->store_p_id}}_increment" class="cart-click add-to-cart-qty input-group-text">+</a>
                                                    </div>
                                                    <input id="{{$product->store_p_id}}" name="pQty" type="number" class="form-control text-center" value="1" readonly>
                                                    <div class="input-group-append">
                                                        <a id="{{$product->store_p_id}}_decrement" class="cart-click add-to-cart-qty input-group-text">-</a>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="product_content grid_content pb-3">
                                                <button type="submit" id="{{$product->store_p_id}}_addToCart" class="add-to-cart btn add-to-cart-btn">Add to Cart</button>
                                            </div> -->
                                        </div>
                                    </form>
                                </div>
                            @endforeach
                        </div>
                        <!--shop toolbar end-->
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--shop  area end-->

</section>
@endsection

@section('js')
<script>
    $(document).ready(function(){
        //cart increment and decrement
        var cartError=$("#cartErrorInput").val();
        if(cartError>0){
            $("#showErrorModal").modal('show');
        }
        else{
            $("#showErrorModal").modal('hide');
        }
        $(".cart-click").click(function(){
            let item_id_w=$(this).attr('id');
            let item_id_explide=item_id_w.split('_');

            let item_id='#'+item_id_explide[0];
            let pQty=parseInt($(item_id).val());

            if(item_id_explide[1]=='increment')
            {
                pQty=pQty+1;
                $(item_id).val(pQty);
            }
            else if(item_id_explide[1]=='decrement')
            {
                if(pQty>0)
                {
                    pQty=pQty-1;
                    $(item_id).val(pQty);
                }
            }

            //disabled and enabled add to cart button
            let addToCart=item_id+'_addToCart';
            if(pQty<=0)
            {
                $(addToCart).prop('disabled', true);
            }
            else
            {
                $(addToCart).prop('disabled', false);
            }
        });


    }); 
</script>
@endsection
