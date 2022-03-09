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
            <div class="col-12 col-md-3">
                    <!--sidebar widget start-->
                    <aside class="sidebar_widget">
                        <div class="widget_inner">
                            <div class="widget_list widget_categories">
                                <h3>Category</h3>
                                <ul>
                                    @php $count=0; @endphp
                                    @foreach($catList as $item)
                                    @php $count++; @endphp
                                    <li class="widget_sub_categories sub_categories{{$count}}"><a href="javascript:void(0)">{{ $item['parent'] }}</a>
                                        <ul class="widget_dropdown_categories dropdown_categories{{$count}}">
                                            
                                            @foreach($item['child'] as $child)
                                            
                                                @php $url='/all/products/category/'.$child['name']; @endphp
                                                <li><a href="{{ url($url) }}">{{ $child['name'] }}</a></li>
                                            
                                            @endforeach
                                            
                                        </ul>
                                    </li>
                                    @endforeach
                                    <span class="totalParentCategory" hidden>{{ $count }}</span>
                                </ul>
                            </div>
                            <!-- <div class="widget_list widget_manu">
                                <h3>Manufacturer</h3>
                                <ul>
                                    <li>
                                        <a href="#">Uniliver <span>(6)</span></a> 
                                    </li>
                                    <li>
                                        <a href="#">Acme <span>(10)</span></a> 
                                    </li>
                                    <li>
                                        <a href="#">ACI <span>(4)</span></a> 
                                    </li>
                                    <li>
                                        <a href="#">Square <span>(10)</span></a> 
                                    </li>                               
                                </ul>
                            </div> -->

                        </div>
                    </aside>
                    <!--sidebar widget end-->
                </div>
                <div class="col-12 col-md-9">
                    <!--shop toolbar start-->
                    <div class="shop_toolbar_wrapper">
                        <!-- <div class="page_amount"> -->
                            <div class="col-12 ">
                                <div class="search_box search_five mobail_s_none">
                                    <form action="{{ route('all.products.src') }}" method="post">
                                        @csrf
                                        <input placeholder="Search Products here..." type="text" name="prod_name">
                                        <button type="submit"><span class="lnr lnr-magnifier"></span></button>
                                    </form>
                                </div>
                            </div>
                        <!-- </div> -->
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
                                <div class="col-lg-3 col-md-3 col-sm-6 col-6  p-2">
                                    <form action="{{ route('gen-add-to-cart')}}" method="post">
                                        @csrf
                                        <input type="hidden" name="gen_p_id" value="{{$product->store_p_id}}">
                                        <a href="{{ url('/all/products/'.$product->product_id) }}">
                                            <div class="single_product shadow">
                                                <div class="product_thumb">
                                                    <img src="{{ env('ADMIN_PANEL').'images/products/'.$product->product_id.'-1.jpg' }}" alt="">
                                                    <!-- <div class="label_product">
                                                        <span class="label_sale">Sale</span>
                                                        <span class="label_new">New</span>
                                                    </div> -->
                                                </div>
                                                <div class="product_content grid_content">
                                                    <a href="{{ url('/all/products/'.$product->product_id) }}">
                                                        <h4 class="product_name p-2">{{ $product->product_name }}</h4>
                                                    </a>
                                                </div>
                                            </div>
                                        </a>
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
