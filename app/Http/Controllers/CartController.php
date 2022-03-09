<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;
use Cookie;


class CartController extends Controller
{
    //
    public function Cart()
    {
        # code...
        if(Session::get('login')){
            $cartItems=$this->getCartItemsDB();
        }
        else{
            $cartItems=$this->getCartItemSession();
        }

        $cartStoreId=$this->GetCartShop();
        
        $shopDelCharge=$this->GetDeliveryCharge($cartStoreId);
        
        $this->getCartInfo();

        return view('cart.index',compact('cartItems','cartStoreId','shopDelCharge'));
    }

    public function AddToCart(Request $req)
    {
        # code...
        if(Session::get('login')){
            if(!$this->CheackShopSame($req->gen_p_id)){
                return back()->with('error','You can not add products from different shop to the cart!');
            }
            $delSql="DELETE FROM `gen_carts` WHERE gen_p_id='".$req->gen_p_id."' and customer_id='".session('u_id')."'";
            DB::delete($delSql);

            $insertSql="INSERT INTO `gen_carts`(`customer_id`, `gen_p_id`, `qty`) VALUES ('".session('u_id')."','".$req->gen_p_id."',$req->pQty)";
     
            DB::insert($insertSql);

            $this->getCartInfo();
            
            return back()->with('success','Added to cart successfully!');
        }
        else{
            $cart=session('cart');

            // var_dump($this->CheackShopSame($req->gen_p_id));
            // die;

            if(!$this->CheackShopSame($req->gen_p_id)){
                return back()->with('error','You can not add products from different shop to the cart!');
            }

            $cart[$req->gen_p_id]=array(
                'p_id'=>$req->gen_p_id,
                'p_qty'=>$req->pQty
            );

            session()->put('cart',$cart);
            $this->getCartInfo();

            $cart=session('cart');

            return back()->with('success','Added to cart successfully!');
        }
    }

    public function CheackShopSame($genProductId)
    {
        # code...
        #if gen product id=gencartshop then return true else false
        $sql="SELECT `store_id` FROM `store_products` WHERE `id`='".$genProductId."'";

        $result=DB::select($sql);
        
        $storeId=$result[0]->store_id;


        if($this->GetCartShop()==$storeId || $this->GetCartShop()==null){
            return true;
        }else{
            return false;
        }
    }

    public function GetDeliveryCharge($shopId)
    {
        # code...
        $sql="SELECT `del_charge` FROM `user_seller` WHERE `id`='$shopId'";
        $data=DB::select($sql);

        if($data){
            return $data[0]->del_charge;
        }
        else{
            return 0;
        }
    }
    public function GetCartShop(){
        #get products item from cart, if logged in then get from db else session, then cheak the product shop  id and return that.
        if(Session::get('login')){
            $sql="SELECT store_products.store_id as storeId
            FROM `gen_carts`,`store_products` 
            WHERE 
            gen_carts.gen_p_id=store_products.id AND
            gen_carts.customer_id='".session('u_id')."' and
            active='1'";

            $result=DB::select($sql);

            if(count($result)==0){
                return 0;
            }
            else{
                return $result[0]->storeId;            
            }            
        }
        else{
            $cart=session('cart');

            
            $newCart=array();

            if($cart==null){
                return null;
            }

            $productId="";
            foreach($cart as $items){
                $productId=$items['p_id'];
            }

            $sql="SELECT `store_id` FROM `store_products` WHERE `id`='".$productId."'";

            $result=DB::select($sql);

            
            $storeId=$result[0]->store_id;
            

            return $storeId;
        }
    }

    public function UpdateQty()
    {
        # code...
        $pId=$_GET['pId'];
        $qty=$_GET['qty'];
        if(Session::get('login')){
            $sql="UPDATE `gen_carts` SET `qty`='".$qty."' WHERE `customer_id`='".session('u_id')."' and `gen_p_id`='".$pId."' and `active`='1' ";

            DB::update($sql);
        }
        else{
            $cart=session('cart');
            $cart[$pId]['p_qty']=$qty;
            session()->put('cart',$cart);
            $cart=session('cart');
        }
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

    public function RemoveCartProduct($productId)
    {
        # code...
        echo $productId;
        if(Session::get('login')){
            
            $cartSql="DELETE FROM `gen_carts` WHERE `gen_p_id`='".$productId."' and `customer_id`='".session('u_id')."'";
            $cartNum=DB::delete($cartSql);
        }
        else{
            $cart=session('cart');
            unset($cart[$productId]);
            session()->put('cart',$cart);
        }

        return back();
    }

    public function MiniCartData()
    {
        # code...

        if(Session::get('login')){
            $cartItems=$this->getCartItemsDB();
        }
        else{
            $cartItems=$this->getCartItemSession();
        }


        // echo "Hello";
        return view('cart.miniCartTable',compact('cartItems'));
    }

    public function MiniCartSum(){
        if(Session::get('login')){
            $cartItems=$this->getCartItemsDB();
        }
        else{
            $cartItems=$this->getCartItemSession();
        }
        $sum=0;
        
        foreach($cartItems as $items){
            $sum=$sum+($items->qty*$items->sale_price);
        }
        
        return view('cart.miniCartSum',compact('sum'));
    }

    public function getCartItemsDB()
    {
        # code...
        $uId=Session::get('u_id');
        $sql="SELECT store_products.id as id, store_products.prod_id as imageId,store_products.title as title, store_products.sale_price as sale_price,gen_carts.qty as qty
        FROM `gen_carts`,`store_products`
        WHERE 
        gen_carts.customer_id='$uId' AND
        gen_carts.gen_p_id=store_products.id and 
        active=1";

        $cartItems=DB::select($sql);

        return $cartItems;
    }
    public function MiniCartTest()
    {
        # code...
        $this->getCartItemSession();
    }
    public function getCartItemSession()
    {
        # code...
        $cart=session('cart');
        $newCart=array();

        if($cart==null){
            return $newCart;
        }

        $productId="";
        foreach($cart as $items){
            $productId=$productId.$items['p_id'].",";
        }
        $productId=$productId."0";

        $qry="SELECT store_products.id as id, store_products.prod_id as imageId,store_products.title as title, store_products.sale_price as sale_price
        FROM `store_products` 
        WHERE 
        store_products.id in ($productId)";
        $products=DB::select($qry);
        


        foreach($products as $product){
            $tempCart=(object)array(
                "id"=> $product->id,
                "imageId"=> $product->imageId,
                "title"=> $product->title,
                "sale_price"=>$product->sale_price,
                "qty"=>$cart[$product->id]['p_qty']
            );
            array_push($newCart,$tempCart);
        }

        return $newCart;
    }
}
