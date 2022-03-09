<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;


class ProductController extends Controller
{
    //
    public function productDetails($pId,$shopId)
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
        products.description as product_description,
        products.unit_mrp,
        products.status as product_status 
        FROM `store_products`,products 
        where products.status='active' and 
        store_products.store_enlist=1 and 
        store_products.prod_id=products.id and 
        store_products.id=".$pId;

        $products=DB::select($sql);

        return view('product.detailsProduct',compact('shopId','products','shopName'));
    }

    public function detailProductAll($pId)
    {
        # code...
        $this->getCartInfo();

        $sqlProductDetails="SELECT 
        products.id as product_id,
        products.title as product_name,
        products.description as product_description,
        products.category as product_category,
        products.sub_category as product_sub_category,
        products.brand as product_brand

        FROM `store_products`,products 
        where products.status='active' and 
        products.id=".$pId."
        
        GROUP BY product_id";

        $productsDetails=DB::select($sqlProductDetails);


        $sqlShop="SELECT 
        user_seller.id as id,
        user_seller.shop_name as shop_name,
        user_seller.district as district,
        user_seller.del_area as del_area,
        store_products.id as store_p_id,
        store_products.sale_price,
        store_products.stock,
        products.unit_mrp,
        products.status as product_status 
        FROM `store_products`,products,user_seller
        where products.status='active' and 
        store_products.store_enlist=1 and 
        store_products.prod_id=products.id and 
        products.id=".$pId." and
        user_seller.id=store_products.store_id
        
        
        GROUP BY store_p_id
        ORDER BY store_products.stock DESC
        ";

        $shops=DB::select($sqlShop);
        
 

        return view('allProducts.detailProduct',compact('pId','productsDetails','shops'));
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
