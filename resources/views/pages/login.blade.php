@extends('main.header-footer')

@section('main_content')
<section class="main_content">
     <!-- customer login start -->
    <!-- customer login start -->
    <div class="customer_login">
        <div class="container">
            <div class="row justify-content-center">
                <!--login area start-->
                <div class="col-lg-6 col-md-6">
                    <div class="account_form">
                        <h2 class="text-center">login to amardokan</h2>
                        @if(session('regUniqError'))
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <strong>{{ session('regUniqError') }}</strong> 
                        </div>
                        @endif
                        <form action="{{ url('/make/login') }}" method="post" class="shadow-lg">
                            @csrf
                            <p>   
                                <label>Email <span>*</span></label>
                                <input type="email" name="user_email" value="{{ old('user_email') }}">
                                @error('user_email')
                                    <div class="form-text text-danger">{{ $message }}</div>
                                @enderror
                            </p>
                            <p>   
                                <label>Passwords <span>*</span></label>
                                <input type="password" name="user_pass" value="{{ old('user_pass') }}">
                                @error('user_pass')
                                    <div class="form-text text-danger">{{ $message }}</div>
                                @enderror
                            </p>   
                            <div class="login_submit">
                                <a href="#">Lost your password?</a>
                                <label for="remember">
                                    <input id="remember" type="checkbox">Remember me
                                </label>
                                <button type="submit" >login</button>
                            </div>
                        </form>
                </div>
                </div>    
            </div>
            <!--login area start-->
        </div>
    </div>
</section>
    
@endsection


