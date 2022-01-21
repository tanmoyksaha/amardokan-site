@foreach($cartItems as $items)
    <div class="cart_item">
        <div class="cart_img">
            <a href="#"><img src=" {{ env('ADMIN_PANEL').'images/products/'.$items->imageId.'-1.jpg' }}" alt=""></a>
        </div>
        <div class="cart_info">
            <a href="#">{{ $items->title }}</a>
            <p>{{ $items->qty }} x <span> ৳{{ $items->sale_price }} </span></p>    
        </div>
        <!-- <div class="cart_remove">
            <a href="#"><i class="icon-x"></i></a>
        </div> -->
    </div>
@endforeach