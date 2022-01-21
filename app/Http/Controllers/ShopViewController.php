<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;


class ShopViewController extends Controller
{
    //
    public function ShopView($shopId)
    {
        
        # code...
        $this->getCartInfo();
        $sql="select shop_name from user_seller where id=".$shopId;
        $shopName=DB::select($sql);
        
        $sql="SELECT store_products.id as store_p_id,
        products.id as product_id, 
        store_products.sale_price,
        store_products.abl_com_amnt,
        store_products.stock,
        store_products.store_enlist,
        products.title as product_name,
        products.unit_mrp,
        products.status as product_status 
        FROM `store_products`,products 
        where products.status='active' and 
        store_products.store_enlist=1 and 
        store_products.prod_id=products.id and 
        store_products.store_id=".$shopId;

        $products=DB::select($sql);
        return view('shopview.index',compact('shopId','products','shopName'));
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
            if($cart!=NULL){
                $cartInfo['number']=count($cart);
            }
            else{
                $cartInfo['number']=0;
            }
        }
        
        session()->put('cartInfo',$cartInfo);
    }
}
