@extends('main.header-footer')

@section('main_content')
<section class="main_content">
    <!--breadcrumbs area start-->
    <div class="breadcrumbs_area text-light shadow-sm border-primary">
        <div class="container">   
            <div class="row">
                <div class="col-12">
                    <div class="breadcrumb_content">
                        <h3>My Account</h3>
                        <ul>
                            <li><a href="{{ route('home') }}">home</a></li>
                            <li>My account</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>         
    </div>
    <!--breadcrumbs area end-->
    <!-- my account start  -->
    <section class="main_content_area">
        <div class="container">   
            <div class="account_dashboard">
                <div class="row">
                    <div class="col-sm-12 col-md-3 col-lg-3">
                        <!-- Nav tabs -->
                        <div class="dashboard_tab_button">
                            <ul role="tablist" class="nav flex-column dashboard-list" id="nav-tab">
                                <li> <a href="#dashboard" data-toggle="tab" class="nav-link" hidden>Dasboard</a></li>
                                <li> <a href="#orders" data-toggle="tab" class="nav-link active">Orders</a></li>
                                <li><a href="#account-details" data-toggle="tab" class="nav-link">Account details</a></li>
                                <li><a href="{{ route('account.logout') }}" class="nav-link" hidden>Log Out</a></li>
                            </ul>
                        </div>    
                    </div>
                    <div class="col-sm-12 col-md-9 col-lg-9">
                        <!-- Tab panes -->
                        <div class="tab-content dashboard_content">
                            <div class="tab-pane fade" id="dashboard" hidden>
                                <div class="text-center mb-3">
                                    <span class="text-dark h4">New Massages</span>
                                </div>
                                <div class="table-responsive">
                                    <table class="table">
                                        <thead>
                                            <tr>
                                                <th>Date</th>
                                                <th>From</th>
                                                <th>Massage</th>
                                                <th>More</th>	 	 	 	
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr >
                                                <td>May 10, 2018</td>
                                                <td>Admin</td>
                                                <td class="text-break">
                                                    hellohellohellohellohellohellohellohellohellohellohellohellohellohellohellohellohellohellohellohellohellohellohello 

                                                </td>
                                                <td>
                                                    <button class="btn btn-dark">Read More</button>
                                                </td>
                                            </tr>
                                            <tr >
                                                <td>May 10, 2018</td>
                                                <td>Seller</td>
                                                <td class="text-break">
                                                    hellohellohellohellohellohellohellohellohellohellohellohellohellohellohellohellohellohellohellohellohellohellohello 

                                                </td>
                                                <td>
                                                    <button class="btn btn-dark">Read More</button>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="tab-pane fade show active" id="orders">
                                <h3>Orders</h3>
                                <div class="table-responsive">
                                    <table class="table">
                                        <thead>
                                            <tr>
                                                <th>No</th>
                                                <th>Invoice</th>
                                                <th>Date</th>
                                                <th>Status</th>	 	 	 	
                                                <th>Actions</th>	 	 	 	
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach($orderData as $item)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>{{ $item->invoice }}</td>
                                                <td>{{ $item->date_time }}</td>
                                                <td><span class="success">{{ $item->status }}</span></td>
                                                @php $url="/checkoutInvoice/".$item->id; @endphp
                                                <td><a href="{{ URL($url) }}" class="view">view</a></td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <div class="tab-pane fade" id="account-details">
                                <h3>Account details </h3>
                                <div class="login">
                                    <div class="login_form_container">
                                        <div class="account_login_form">
                                            
                                            <form action="{{ route('account.edit') }}" method="post">
                                                @csrf
                                                <span class="row">
                                                    <input type="hidden" value="{{ $customerData[0]->id }}">
                                                    <p class="col-12 col-md-6">   
                                                        <label>Mobile  <span>*</span></label>
                                                        <input type="tel" name="cusMobile" value="{{ $customerData[0]->mobile }}">
                                                    </p>
                                                    <p class="col-12 col-md-6">   
                                                        <label>Name  <span>*</span></label>
                                                        <input type="text" name="cusName" value="{{ $customerData[0]->name }}">
                                                    </p>
                                                    <p class="col-12 col-md-6">   
                                                        <label>Billing Address  <span>*</span></label>
                                                        <input type="text" name="cusAddress" value="{{ $customerData[0]->billing_address }}">
                                                    </p>
                                                    <p class="col-12 col-md-6">   
                                                        <label>Email  <span></span></label>
                                                        <input type="email" name="cusEmail" value="{{ $customerData[0]->email }}">
                                                    </p>
                                                    <p class="col-12 col-md-6">   
                                                        <label>Birthdate</label>
                                                        <input type="text" placeholder="MM/DD/YYYY" name="birthday" value="{{ $customerData[0]->b_date }}">
                                                        <span class="example">
                                                        (E.g.: 05/31/1970)
                                                        </span>
                                                    </p>
                                                    <p class="col-12 col-md-6">   
                                                        <label>Refference No  <span>*</span></label>
                                                        <input type="text" name="reffNo" value="{{ $customerData[0]->reff_rin }}">
                                                    </p>
                                                    <p class="col-12 col-md-6">   
                                                        <label>Bloog Group  <span>*</span></label>
                                                        <input type="text" name="bloodGroup" value="{{ $customerData[0]->blood_group }}">
                                                    </p>
                                                    <p class="col-12 col-md-6" hidden>   
                                                        <label>Profile Picture  <span>*</span></label>
                                                        <input type="file">
                                                    </p>
                                                    <div class="save_button primary_btn default_button">
                                                        <button class="btn btn-lg btn-dark" type="submit">Save</button>
                                                    </div>
                                                </span>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>  
        </div>        	
    </section>			
    <!-- my account end   --> 
</section>
    
@endsection


