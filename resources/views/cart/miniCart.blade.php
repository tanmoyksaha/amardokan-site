<div class="mini_cart">
    <div class="cart_gallery">
        <div class="cart_close">
            <div class="cart_text">
                <h3>cart</h3>
            </div>
            <div class="mini_cart_close">
                <a href="javascript:void(0)"><i class="icon-x"></i></a>
            </div>
        </div>
        <input type="hidden" id="miniCartLinkTable" value="{{ route('mini-cart-data') }}">
        <input type="hidden" id="miniCartLinkSum" value="{{ route('mini-cart-sum') }}">
        <div class="minicart-item-list" id="mini-cart-list">
            
        </div>
    </div>
    <div class="mini_cart_table" id="mini_cart_table">
        
    </div>
    
    <div class="mini_cart_footer sticky-bottom mb-10">
        <div class="cart_button">
            <a href="{{ route('cart') }}"><i class="fa fa-shopping-cart"></i> View cart</a>
        </div>
        <div class="cart_button">
            <a href="{{ route('checkout') }}"><i class="fa fa-sign-in"></i> Checkout</a>
        </div>
    </div>
</div>
