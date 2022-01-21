<div class="row">
    @isset($shopData)
    @foreach($shopData as $shop)
        <div class="p-3 col-lg-2 col-md-3 col-sm-3  col-6 ">
            <a href="{{ route('shop.view',['shopId'=>$shop->id]) }}">
            
                @php
                    $imgLink=env('ADMIN_PANEL')."images/shop_banner/".$shop->id.".png"
                @endphp
                <img src="{{ $imgLink }}" class="img-fluid border shadow-sm">
            </a>
        </div>
    @endforeach
    @endif
    
</div>

<script>
    $(document).ready(function(){
        $('img').lazyload();
    });
</script>