<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;


class HomeController extends Controller
{
    //
    function home()
    {
        // $sql="SELECT user_seller.`id`
        //         FROM `user_seller`
        //         WHERE status='active'";
        
        $sql="SELECT user_seller.id, user_seller.email, user_seller.mobile, user_seller.own_name, user_seller.shop_name, user_seller.district,
            		(
                    	SELECT COUNT(str_products.prod_id)
                        FROM store_products as str_products
                        WHERE 
                        str_products.store_id=user_seller.id AND
                        str_products.store_enlist=1
                        
                        GROUP BY str_products.store_id
                    ) as liveProducts
            
            FROM user_seller
            WHERE status='active'
            ORDER BY liveProducts DESC
            ";
        
        // $sql="SELECT user_seller.`id`,COUNT(store_products.prod_id) as store_p_count
        //         FROM `user_seller`,store_products
        //         WHERE 
        //         store_products.store_id=user_seller.id and
        //         store_products.store_enlist='1'
                
        //         GROUP BY id
                
        //         ORDER BY store_p_count DESC";
        $shopData=DB::select($sql);

        $this->getCartInfo();
        return view('home.home',compact('shopData'));
    }
    function test()
    {
        return view('home.test');
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
    public function getCartItems()
    {
        # code...
        $uId=Session::get('u_id');
        $sql="SELECT store_products.id as id, store_products.prod_id as imageId,store_products.title as title, store_products.sale_price as sale_price,gen_carts.qty as qty
        FROM `gen_carts`,`store_products`
        WHERE 
        gen_carts.customer_id='$uId' AND
        gen_carts.gen_p_id=store_products.id";

        $cartItems=DB::select($sql);

        return $cartItems;
    }
   
}
