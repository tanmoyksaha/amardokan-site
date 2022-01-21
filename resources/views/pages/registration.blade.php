@extends('main.header-footer')

@section('main_content')
<section class="main_content">
     <!-- customer login start -->
    <div class="customer_login">
        <div class="container">
            <div class="row justify-content-center">
                <!--login area start-->
                <div class="col-lg-8 col-md-8 col-12">
                    <div class="account_form register">
                        <h2 class="text-center">Register</h2>
                        @if(session('regUniqError'))
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <strong>{{ session('regUniqError') }}</strong> 
                        </div>
                        @endif
                        <form action="{{ route('create.user') }}" method="post" class="shadow-lg">
                            @csrf
                            <span class="row">
                                <div class="col-12 col-md-6 p-1">   
                                    <label>Email  <span>*</span></label>
                                    <input type="email" name="user_email" value="{{ old('user_email') }}">
                                    @error('user_email')
                                        <div class="form-text text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-12 col-md-6 p-1">   
                                    <label>Mobile  <span>*</span></label>
                                    <input type="tel" name="user_mobile" value="{{ old('user_mobile') }}">
                                    @error('user_mobile')
                                        <div class="form-text text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-12 col-md-12 p-1">   
                                    <label>Refference No  <span>*</span></label>
                                    <input type="text" name="user_reff" value="{{ old('user_reff') }}">
                                    @error('user_reff')
                                        <div class="form-text text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-12 col-md-6 p-1">   
                                    <label>Password <span>*</span></label>
                                    <input type="password" name="user_pass" value="{{ old('user_pass') }}">
                                    @error('user_pass')
                                        <div class="form-text text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="col-12 col-md-6 p-1">   
                                    <label>Confirm Password <span>*</span></label>
                                    <input type="password" name="user_confirm_pass" value="{{ old('user_confirm_pass') }}">
                                    @error('user_confirm_pass')
                                        <div class="form-text text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="login_submit">
                                    <button type="submit" name="user_reg">Register</button>
                                </div>
                            </span>
                        </form>
                    </div>
                </div>    
            </div>
            <!--login area start-->
        </div>
    </div>
</section>
    
@endsection


