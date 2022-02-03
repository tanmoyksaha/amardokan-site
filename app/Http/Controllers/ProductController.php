<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class ProductController extends Controller
{
    //
    public function productDetails($pId,$shopId)
    {
        # code...
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
        return view('allProducts.detailProduct');
    }
}
