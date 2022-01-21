@extends('main.header-footer')

@section('main_content')
<section class="main_content">
    <!--breadcrumbs area start-->
    <div class="breadcrumbs_area">
        <div class="container">   
            <div class="row">
                <div class="col-12">
                    <div class="breadcrumb_content text-light">
                        <h3 >Cart</h3>
                    </div>
                </div>
            </div>
        </div>         
    </div>
    <!--breadcrumbs area end-->
    <!--shopping cart area start -->
    <div class="shopping_cart_area mt-70">
        <div class="container">  
            <form action="#"> 
                <div class="row">
                    <div class="col-12">
                        <div class="table_desc">
                            <div class="cart_page">
                                <table>
                                    <thead>
                                        <tr>
                                            <th class="product_remove">Delete</th>
                                            <th class="product_thumb">Image</th>
                                            <th class="product_name">Product</th>
                                            <th class="product-price">Price</th>
                                            <th class="product_quantity">Quantity</th>
                                            <th class="product_total">Total</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php
                                            $totalSum=0;
                                        @endphp
                                        @foreach($cartItems as $items)
                                        <tr>
                                            @php $totalSum=$totalSum+($items->sale_price*$items->qty); @endphp  
                                            <td class="product_remove"><a href="{{ route('remove-product',['productId'=>$items->id]) }}"><i class="fa fa-trash-o"></i></a></td>
                                            <td class="product_thumb">
                                                <a href="#">
                                                    <img src="{{ env('ADMIN_PANEL').'images/products/'.$items->imageId.'-1.jpg' }}" alt="">
                                                </a>
                                            </td>
                                            <td class="product_name">
                                                <a href="#">
                                                    {{ $items->title }}
                                                </a>
                                            </td>
                                            <td class="product-price">৳<span id="{{$items->id}}_salePrice">{{ $items->sale_price }}</span></td>
                                            <td class="product_quantity">
                                                <div class="product_content grid_content ">
                                                    <div class="input-group px-4">
                                                        <div class="input-group-prepend">
                                                            <a id="{{$items->id}}_increment" class="cart-click add-to-cart-qty input-group-text">+</a>
                                                        </div>
                                                        <input id="{{$items->id}}" name="pQty" type="number" class="form-control text-center" value="{{ $items->qty }}" readonly>
                                                        <div class="input-group-append">
                                                            <a id="{{$items->id}}_decrement" class="cart-click add-to-cart-qty input-group-text">-</a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="product_total">৳ <span id="{{$items->id}}_total">{{ $items->sale_price*$items->qty }}</span></td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>   
                            </div>  
                            <!-- <div class="cart_submit">
                                <button type="submit">update cart</button>
                            </div>       -->
                        </div>
                        </div>
                    </div>
                    <!--coupon code area start-->
                <div class="coupon_area">
                    <div class="row">
                        <div class="col-lg-12 col-md-12">
                            <div class="coupon_code right">
                                <h3>Cart Totals</h3>
                                <div class="coupon_inner">
                                    <div class="cart_subtotal">
                                        <p>Subtotal</p>
                                        <p class="cart_amount">৳{{$totalSum}}</p>
                                    </div>
                                    <div class="cart_subtotal ">
                                        <p>Shipping</p>
                                        <p class="cart_amount"><span>Flat Rate:</span> ৳{{ $shopDelCharge }}</p>
                                    </div>

                                    <div class="cart_subtotal">
                                        <p>Total</p>
                                        <p class="cart_amount">৳{{$totalSum+$shopDelCharge}}</p>
                                    </div>
                                    <div class="row">
                                        <div class="col-7">
                                            
                                        </div>
                                        <div class="col-3">
                                            <div class="checkout_btn">
                                                @if($cartStoreId!=null)
                                                    <a href="{{ route('shop.view',['shopId'=>$cartStoreId])}}">Continue Shopping</a>
                                                @else
                                                    <a href="{{ route('home') }}">Continue Shopping</a>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="col-2">
                                            <div class="checkout_btn">
                                                <a href="{{ route('checkout') }}">Easy Checkout</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!--coupon code area end-->
            </form> 
        </div>     
    </div>
    <!--shopping cart area end -->
</section>
@endsection

@section('js')
<script>
    $(document).ready(function(){
        //cart increment and decrement
        $(".cart-click").click(function(){
            let item_id_w=$(this).attr('id');
            let item_id_explide=item_id_w.split('_');

            let item_id='#'+item_id_explide[0];
            let pQty=parseInt($(item_id).val());
            let salePrice=$(item_id+"_salePrice").html();

            if(item_id_explide[1]=='increment')
            {
                pQty=pQty+1;
                $(item_id).val(pQty);
                
                productTotal(salePrice,pQty,item_id);
                supdateQTY(item_id_explide[0],pQty);
            }
            else if(item_id_explide[1]=='decrement')
            {
                if(pQty>0)
                {
                    pQty=pQty-1;
                    $(item_id).val(pQty);
                    productTotal(salePrice,pQty,item_id);
                    supdateQTY(item_id_explide[0],pQty);
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
    function productTotal(salePrice,qty,id){
        let sum=salePrice*qty;
        $(id+"_total").html(sum);
    }
    function supdateQTY(pId,qty){
        let link="{{env('SITE_URL').'update-qty'}}";
        $.ajax({
            url: link,
            type: "GET",
            data:{
                pId: pId,
                qty: qty
            },
            success: function(result){
                location.reload();
            },
            error: function (jqXHR, textStatus, errorThrown){
                alert(jqXHR.responseText+""+errorThrown+" "+textStatus);
            }
        });
    } 
</script>
@endsection
