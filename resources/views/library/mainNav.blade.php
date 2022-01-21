<div class="header_middle header_middle5">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-3 col-md-3 col-sm-3 col-3">
                <div class="logo">
                    @php
                        $logoUrl=env('SITE_URL').'assets/logo/logo.png';
                    @endphp
                    <a href="{{ route('home') }}"><img src="{{$logoUrl}}" alt=""></a>
                </div>
            </div>
            <div class="col-lg-6  col_search5">
                <div class="search_box search_five mobail_s_none">
                    <form action="#">
                        <input placeholder="Search here..." type="text">
                        <button type="submit"><span class="lnr lnr-magnifier"></span></button>
                    </form>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 col-sm-7 col-8">
                <div class="header_account_area">
                    <div class="header_account_list register text-center">
                        <ul>
                            @if(session('login'))
                                <li><a href="{{ route('pages.myaccount') }}">My Account</a></li>
                                <li><span>/</span></li>
                                <li><a href="{{ route('account.logout') }}">Log Out</a></li>
                            @else
                                <li><a href="{{ route('pages.registration') }}">Register</a></li>
                                <li><span>/</span></li>
                                <li><a href="{{ route('pages.login') }}">Login</a></li>
                            @endif
                        </ul>
                    </div>
                    <div class="header_account_list  mini_cart_wrapper">
                        @php
                            $cartInfo=session('cartInfo');
                            
                        @endphp
                        <a href="javascript:void(0)"><span class="lnr lnr-cart"></span><span class="item_count">{{$cartInfo['number']}}</span></a>
                        <!--mini cart-->
                        @include("cart.miniCart")
                        <!--mini cart end-->
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="header_bottom sticky-header">
    <div class="container">  
        <div class="row align-items-center">
            <div class="col-12 col-md-12 col-sm-12 mobail_s_block">
                <div class="search_box search_five">
                    <form action="#">
                        <input placeholder="Search here..." type="text">
                        <button type="submit"><span class="lnr lnr-magnifier w-10"></span></button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
