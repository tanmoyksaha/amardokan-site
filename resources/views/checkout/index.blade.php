@extends('main.header-footer')

@section('main_content')
    <section class="main_content">
        <!--breadcrumbs area start-->
        <div class="breadcrumbs_area">
            <div class="container">   
                <div class="row">
                    <div class="col-12">
                        <div class="breadcrumb_content text-light">
                            <h3 >Checkout</h3>
                        </div>
                    </div>
                </div>
            </div>         
        </div>
        <!--Checkout page section-->
        @if(session('regUniqError'))
            <div class="alert alert-danger alert-dismissible fade show text-center" role="alert">
                <strong>{{ session('regUniqError') }}</strong> 
            </div>
        @endif
        <div class="Checkout_section mt-70">
            <div class="container">
                <div class="row">
                    <div class="col-12">
                        @php
                            $hide="";
                            if(session('login')){
                                $hide="hidden";
                            }
                            $loginCollape="collapse";
                            if($errors->get('user_email') or $errors->get('user_pass')){
                                $loginCollape="";
                            }
                        @endphp
                        <div class="user-actions" {{ $hide }}>
                            <h3> 
                                <i class="fa fa-file-o" aria-hidden="true"></i>
                                Returning customer?
                                <a class="Returning" href="#checkout_login" data-bs-toggle="collapse" aria-expanded="true">Click here to login</a>     

                            </h3>
                            <div id="checkout_login" class="{{ $loginCollape }}" data-parent="#accordion">
                                <div class="checkout_info">
                                    <p>If you have shopped with us before, please enter your details in the boxes below. If you are a new customer please proceed to the Billing & Shipping section.</p>  
                                    <form action="{{ route('make.login.checkout') }}" method="post">
                                        @csrf 
                                        @if(session('regUniqError'))
                                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                            <strong>{{ session('regUniqError') }}</strong> 
                                        </div>
                                        @endif 
                                        <div class="form_group">
                                            <label>Email <span>*</span></label>
                                            <input type="email" name="user_email" value="{{ old('user_email') }}">
                                            @error('user_email')
                                                <div class="form-text text-danger">{{ $message }}</div>
                                            @enderror   
                                        </div>
                                        <div class="form_group">
                                            <label>Passwords <span>*</span></label>
                                            <input type="password" name="user_pass" value="{{ old('user_pass') }}">
                                            @error('user_pass')
                                                <div class="form-text text-danger">{{ $message }}</div>
                                            @enderror
                                        </div> 
                                        <div class="form_group group_3 ">
                                            <button type="submit">Login</button>
                                            <label for="remember_box">
                                                <input id="remember_box" type="checkbox">
                                                <span> Remember me </span>
                                            </label>     
                                        </div>
                                    </form>          
                                </div>
                            </div>    
                        </div>  
                    </div>
                </div>
                <div class="checkout_form">
                    <div class="row">
                        <div class="col-lg-6 col-md-6">
                            <form action="#">    
                                <h3>Your order</h3> 
                                <div class="order_table table-responsive">
                                    <table>
                                        <thead>
                                            <tr>
                                                <th>Product</th>
                                                <th>Total</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @php
                                                $totalSum=0;
                                            @endphp
                                            @foreach($cartItems as $items)
                                                @php $totalSum=$totalSum+($items->sale_price*$items->qty); @endphp  
                                                <tr>
                                                    <td> {{ $items->title }} <strong> × {{ $items->qty }}</strong></td>
                                                    <td> ৳{{ $items->sale_price*$items->qty }}</td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                        <tfoot>
                                            <tr>
                                                <th>Cart Subtotal</th>
                                                <td>৳{{$totalSum}}</td>
                                            </tr>
                                            <tr>
                                                <th>Shipping</th>
                                                <td><strong>৳{{ $shopDelCharge }}</strong></td>
                                            </tr>
                                            <tr class="order_total">
                                                <th>Order Total</th>
                                                <td><strong>৳{{$totalSum+$shopDelCharge}}</strong></td>
                                            </tr>
                                        </tfoot>
                                    </table>     
                                </div>
                                <div class="payment_method col-12">  
                                </div> 
                            </form>         
                        </div>
                        <div class="col-lg-6 col-md-6">
                            <form action="{{ route('finalCheckout') }}" method="post">
                                @csrf
                                <h3>Billing Details</h3>
                                <div class="row">

                                    <div class="col-lg-6 mb-20">
                                        <label>Name <span>*</span></label>
                                        @if(old('billName'))
                                            <input type="text" name="billName" value="{{ old('billName') }}">
                                        @elseif($custData->billName)
                                            <input type="text" name="billName" value="{{ $custData->billName }}">
                                        @else
                                            <input type="text" name="billName" value="">
                                        @endif
                                        @error('billName')
                                            <div class="form-text text-danger">{{ $message }}</div>
                                        @enderror      
                                    </div>
                                    <div class="col-lg-6 mb-20">
                                        <label>Mobile No  <span>*</span></label>
                                        @if(old('billMobileNo'))
                                            <input type="tel" name="billMobileNo" value="{{ old('billMobileNo') }}" pattern="[0]{1}[1]{1}[0-9]{9}">
                                        @elseif($custData->billMobile)
                                            <input type="tel" name="billMobileNo" value="{{ $custData->billMobile }}" pattern="[0]{1}[1]{1}[0-9]{9}">
                                        @else
                                            <input type="tel" name="billMobileNo" value="" pattern="[0]{1}[1]{1}[0-9]{9}">
                                        @endif

                                        <div class="form-text text-dark">e.g 01700000000</div>
                                        @error('billMobileNo')
                                            <div class="form-text text-danger">{{ $message }}</div>
                                        @enderror    
                                    </div>
                                    <div class="col-12 mb-20">
                                        <label>Address</label>
                                        @if(old('billAddress'))
                                            <input type="text" name="billAddress" value="{{ old('billAddress') }}">
                                        @elseif($custData->billAddress)
                                            <input type="text" name="billAddress" value="{{ $custData->billAddress }}">
                                        @else
                                            <input type="text" name="billAddress" value="">
                                        @endif

                                        @error('billAddress')
                                            <div class="form-text text-danger">{{ $message }}</div>
                                        @enderror 
                                    </div>
                                    <div class="col-6 mb-20">
                                        <label for="country">District <span>*</span></label>
                                        <select  name="billDistrict" class="  form-control billDistrict"  id="billDistrict"> 
                                            <option value="">Select</option>      
                                            <option value="2">Dhaka</option>      
                                            <option value="3">Naraynganj</option> 
                                            <option value="4">Noakhali</option>    
                                        </select>
                                        
                                        @error('billDistrict')
                                            <div class="form-text text-danger">{{ $message }}</div>
                                        @enderror 
                                    </div>
                                    <div class="col-6 mb-20">
                                        <label for="country">Thana <span>*</span></label>
                                        <select class="form-control" name="billThana" id="billThana" > 
                                            <option value="">Select</option>      
                                            <option value="2">Rampura</option>      
                                            <option value="3">Banasree</option>  
                                        </select>
                                        @error('billThana')
                                            <div class="form-text text-danger">{{ $message }}</div>
                                        @enderror 
                                    </div>
                                    
                                    <div class="col-lg-6 mb-20">
                                        <label>Refference No  <span>*</span></label>
                                        @if(old('reffNo'))
                                            <input type="text" name="reffNo" value="{{ old('reffNo') }}">
                                        @elseif($custData->reff)
                                            <input type="text" name="reffNo" value="{{ $custData->reff }}">
                                        @else
                                            <input type="text" name="reffNo" value="">
                                        @endif
                                        @error('reffNo')
                                            <div class="form-text text-danger">{{ $message }}</div>
                                        @enderror  
                                    </div>

                                    <div class="col-12 mb-20">
                                        <!-- <input id="account" type="checkbox" data-target="createp_account" /> -->
                                        @php
                                            $collapsePassword="collapse";
                                            if($errors->get('cPassword')){
                                                $collapsePassword="";
                                            }
                                        @endphp

                                        @if(!session('u_id'))
                                        <a data-bs-toggle="collapse" href="#collapseOne"  aria-controls="collapseOne" hidden>Create an account?</a>

                                        <div id="collapseOne" class="{{ $collapsePassword }} one" data-parent="#accordion" hidden>
                                            <div class="card-body1">
                                                <label> Account password   <span>*</span></label>
                                                <input placeholder="Password" type="password" name="password" >  
                                                @error('password')
                                                    <div class="form-text text-danger">{{ $message }}</div>
                                                @enderror 
                                            </div>
                                            <div class="card-body1">
                                                <label> Confirm password   <span>*</span></label>
                                                <input placeholder="Confirm Password" type="password" name="cPassword">  
                                                @error('cPassword')
                                                    <div class="form-text text-danger">{{ $message }}</div>
                                                @enderror 
                                            </div>
                                        </div>
                                        @endif
                                    </div>
                                    <div class="col-12 mb-20">
                                        <!-- <input id="address" type="checkbox" data-target="createp_account"/> -->
                                        <a class="righ_0" href="#collapsetwo" data-bs-toggle="collapse" aria-controls="collapsetwo">Ship to a different address?</a>   
                                        <div id="collapsetwo" class="collapse one" data-parent="#accordion">
                                        <div class="row">
                                            <div class="col-lg-6 mb-20">
                                                    <label>Name <span>*</span></label>
                                                    <input type="text" name="delName" value="{{ old('delName') }}">
                                                    @if(session('delNameError'))
                                                        <div class="form-text text-danger">{{ session('delNameError') }}</div>
                                                    @endif     
                                                </div>
                                                <div class="col-lg-6 mb-20">
                                                    <label>Mobile No  <span>*</span></label>
                                                    <input type="tel" name="delMobile" value="{{ old('delMobile') }}" pattern="[0]{1}[1]{1}[0-9]{9}">
                                                    <div class="form-text text-dark">e.g 01700000000</div>
                                                    @error('delMobile')
                                                        <div class="form-text text-danger">{{ $message }}</div>
                                                    @enderror  
                                                </div>
                                                <div class="col-12 mb-20">
                                                    <label>Address</label>
                                                    <input type="text" name="delAddress" value="{{ old('delAddress') }}">
                                                    @if(session('delAddressError'))
                                                        <div class="form-text text-danger">{{ session('delAddressError') }}</div>
                                                    @endif      
                                                </div>
                                                <div class="col-6 mb-20">
                                                    <label for="country">District <span>*</span></label>
                                                    <select class="form-control" name="delDistrict" id="delDistrict"> 
                                                        <option value="">Select</option>      
                                                        <option value="2">Dhaka</option>      
                                                        <option value="3">Naraynganj</option> 
                                                        <option value="4">Noakhali</option>   
                                                    </select>
                                                    @if(session('delDistrictError'))
                                                        <div class="form-text text-danger">{{ session('delDistrictError') }}</div>
                                                    @endif 
                                                </div>
                                                <div class="col-6 mb-20 ">
                                                    <label for="country">Thana <span>*</span></label>
                                                    <select class="form-control" name="delThana" id="delThana"> 
                                                        <option value="">Select</option>      
                                                        <option value="2">Rampura</option>      
                                                        <option value="3">Banasree</option>  
                                                    </select>
                                                    @if(session('delThanaError'))
                                                        <div class="form-text text-danger">{{ session('delThanaError') }}</div>
                                                    @endif 
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="order-notes">
                                            <label for="order_note">Order Notes</label>
                                            <textarea name="orderNote" value="{{ old('orderNote') }}" placeholder="Notes about your order, e.g. special notes for delivery."></textarea>
                                            @error('orderNote')
                                                <div class="form-text text-danger">{{ $message }}</div>
                                            @enderror 
                                        </div>
                                        <div class="order_button mt-lg-2">
                                            <button  type="submit">Confirm Order</button> 
                                        </div>    
                                    </div>     
                                                                                    
                                </div>
                            </form>    
                        </div>
                    </div>
                </div> 
            </div> 
        </div>       
        <!--Checkout page section end-->
        <script>
    
            $(document).ready(function() {
                //District list
                $("#billDistrict").html("<option default>Select District</option>");

                var api="https://portal2.amarbazarltd.com/ablApi/getDistrict.php?username=ablapi@abl.com&password=1fa960236a09c331615f60afabd0e7e7ffa3f7d508e520d06ea566490c418c67";
                $.ajax({  
                    url:api, 
                    type : "GET",                                  				
                    success : function(result) {
                        $.each(result, function(key, val){
                            $("#billDistrict").append("<option>"+val+"</option>");
                        });
                    }
                });

                $('#billDistrict').on('change', function() {
                    $('#billThana').html('<option default>Select Thana</option>');

                    var dist=$('#billDistrict').val();
                    var api="https://portal2.amarbazarltd.com/ablApi/getThana.php?xdistrict="+dist+"&username=ablapi@abl.com&password=1fa960236a09c331615f60afabd0e7e7ffa3f7d508e520d06ea566490c418c67";
                    $.ajax({  
                        url:api, 
                        type : "GET",                                  				
                        success : function(result) {
                            $.each(result, function(key, val){
                                $('#billThana').append('<option>'+val+'</option>');
                            });
                        }
                    });
                });

                $('#delDistrict').html('<option default>Select District</option>');

                var api="https://portal2.amarbazarltd.com/ablApi/getDistrict.php?username=ablapi@abl.com&password=1fa960236a09c331615f60afabd0e7e7ffa3f7d508e520d06ea566490c418c67";
                $.ajax({  
                    url:api, 
                    type : "GET",                                  				
                    success : function(result) {
                        $.each(result, function(key, val){
                            $('#delDistrict').append('<option>'+val+'</option>');
                        });
                    }
                });

                $('#delDistrict').on('change', function() {
                    $('#delThana').html('<option default>Select Thana</option>');

                    var dist=$('#delDistrict').val();
                    var api="https://portal2.amarbazarltd.com/ablApi/getThana.php?xdistrict="+dist+"&username=ablapi@abl.com&password=1fa960236a09c331615f60afabd0e7e7ffa3f7d508e520d06ea566490c418c67";
                    $.ajax({  
                        url:api, 
                        type : "GET",                                  				
                        success : function(result) {
                            $.each(result, function(key, val){
                                $('#delThana').append('<option>'+val+'</option>');
                            });
                        }
                    });
                });
            });

        </script>
    </section>
@endsection

