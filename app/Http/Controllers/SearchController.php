<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;


class SearchController extends Controller
{
    //
    public function ShopSearchHome(Request $request)
    {
        # code...

        $qryWhere="`shop_name` like '%$request->shopName%'";

        if(strlen($request->district)>0 and $request->district!="Select District"){
            $qryWhere=$qryWhere." AND `district`='$request->district'";
        }

        if(strlen($request->thana)>0 and $request->thana!="Select Thana"){
            $qryWhere=$qryWhere." AND `thana`='$request->thana'";
        }

        $sql="SELECT `id` 
                FROM `user_seller` 
                WHERE 
                status='active' and
                $qryWhere";

        

        $shopData=DB::select($sql);
        
        $this->getCartInfo();
        return view('home.home',compact('shopData'));
    }
    public function ShopSearchCampaign(Request $request)
    {
        # code...

        $qryWhere="`shop_name` like '%$request->shopName%'";

        if(strlen($request->district)>0 and $request->district!="Select District"){
            $qryWhere=$qryWhere." AND `district`='$request->district'";
        }

        if(strlen($request->thana)>0 and $request->thana!="Select Thana"){
            $qryWhere=$qryWhere." AND `thana`='$request->thana'";
        }

        $sql="SELECT `id` 
                FROM `user_seller` 
                WHERE 
                status='active' and
                $qryWhere";

        

        $shopData=DB::select($sql);
        
        $this->getCartInfo();

        $campaignName=$request->campaignName;
        return view('campaign.index',compact('shopData','campaignName'));
    }

    public function getCartInfo()
    {
        if(Session::get('login')){
            $cartSql="select count(*) as cart_num from gen_carts where customer_id='".session('u_id')."' and active=1";
            $cartNum=DB::select($cartSql);
            $cartInfo['number']=$cartNum[0]->cart_num;
        }
        else{
            $cart=session('cart');
            if($cart!=null){
                $cartInfo['number']=count($cart);
            }
            else{
                $cartInfo['number']=0;
            }
        }
        
        session()->put('cartInfo',$cartInfo);
    }
}
