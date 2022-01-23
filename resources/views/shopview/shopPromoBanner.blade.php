<div class="container">
    <div class="row">
        <div class="col-lg-3 col-md-3 col-6">
            <div class="single_banner">
                <div class="">
                    @php $url="/campaign/shop/".$shopId."/Special Combo Offer"; @endphp
                    <a href="{{ url($url) }}"><img src="{{ env('SITE_URL').'assets/promo_banner/promoBanner1.jpg'  }}" class="border rounded shadow-sm lazy img-fluid" alt=""></a> 
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-3 col-6">
            <div class="single_banner">
                <div class="">
                    @php $url="/campaign/shop/".$shopId."/Discount Offer"; @endphp
                    <a href="{{ url($url) }}"><img src="{{ env('SITE_URL').'assets/promo_banner/promoBanner2.jpg'  }}" class="border rounded shadow-sm lazy img-fluid" alt=""></a> 
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-3 col-6">
            <div class="single_banner">
                <div class="">
                    @php $url="/campaign/shop/".$shopId."/Seller Campaign"; @endphp
                    <a href="{{ url($url) }}"><img src="{{ env('SITE_URL').'assets/promo_banner/promoBanner3.jpg'  }}" class="border rounded shadow-sm lazy img-fluid" alt=""></a> 
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-3 col-6">
            <div class="single_banner">
                <div class="">
                    @php $url="/all/products/shop/".$shopId; @endphp
                    <a href="{{ url($url) }}"><img src="{{ env('SITE_URL').'assets/promo_banner/promoBanner4.jpg'  }}" class="border rounded shadow-sm lazy img-fluid" alt=""></a> 
                </div>
            </div>
        </div>
    </div>
</div>