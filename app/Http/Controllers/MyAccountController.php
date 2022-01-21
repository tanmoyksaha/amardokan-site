<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;



class MyAccountController extends Controller
{
    //
    public function MyAccount()
    {
        # code...

        $qry="SELECT * FROM `user_customer` WHERE `id`='".Session::get('u_id')."'";
        $user_data=DB::select($qry);
        $user_data=$user_data[0];

        $sql="SELECT `id`, `date_time`, `invoice`,`status`, `reff_rin` FROM `gen_orders` WHERE `cust_id`='".Session::get('u_id')."'";
        $orderData=DB::select($sql);
        
        $sql="SELECT `id`, `name`, `email`, `mobile`, `billing_address`, `b_date`, `blood_group`, `reff_rin`, `password`, `status` FROM `user_customer` WHERE id='".Session::get('u_id')."'";
        $customerData=DB::select($sql);

        return view('pages.myaccount',compact('user_data','orderData','customerData'));
    }

    public function MyaccountEdit(Request $request)
    {
        # code...
        // var_dump($request);
        // die;
        $qry="UPDATE `user_customer` 
                SET 
                `name`='$request->cusName',
                `email`='$request->cusEmail',
                `mobile`='$request->cusMobile',
                `billing_address`='$request->cusAddress',
                `b_date`='$request->birthday',
                `blood_group`='$request->bloodGroup',
                `reff_rin`='$request->reffNo' 
            WHERE `id`='".Session::get('u_id')."'";

        $result=DB::update($qry);

        return redirect()->back();
    }
    public function Logout()
    {
        # code...
        Session::flush();

        return Redirect()->route('home');
    }
    
}
