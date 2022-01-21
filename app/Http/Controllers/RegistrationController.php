<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\CreateUser;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;


class RegistrationController extends Controller
{
    //
    public function Index()
    {
        # code...
        return view('pages.registration');
    }

    public function CreateUser(Request $request)
    {
        # code...
        $mobileUnqError=0;
        $emailUnqError=0;

        $validated = $request->validate([
            'user_email' => 'required|email',
            'user_mobile' => 'required',
            'user_pass' => 'required|min:5',
            'user_confirm_pass'=> 'required_with:user_pass|same:user_pass|min:6'
        ]);

        $qry="SELECT COUNT(`email`) as 'dup' FROM `user_customer` WHERE email='".$request->user_email."'";
        $count_email=DB::select($qry);
        $qry="SELECT COUNT(`mobile`) as 'dup' FROM `user_customer` WHERE mobile='".$request->user_mobile."'";
        $count_mobile=DB::select($qry);


        if($count_email[0]->dup>0){
            $emailUnqError++;
        }
        if($count_mobile[0]->dup>0){
            $mobileUnqError++;
        }

        if($mobileUnqError>0 && $emailUnqError>0){
            return Redirect()->back()->with('regUniqError','Email and Mobile is Already Exist!')->withInput();
        }
        elseif($mobileUnqError>0){
            return Redirect()->back()->with('regUniqError','Mobile is Already Exist!')->withInput();
        }
        elseif($emailUnqError>0){
            return Redirect()->back()->with('regUniqError','Email is Already Exist!')->withInput();
        }
        


        $data=array();
        $data['email'] = $request->user_email;
        $data['mobile']  = $request->user_mobile;
        $data['reff_rin']  = $request->user_reff;
        $data['password']  = Hash::make($request->user_pass);
        $data['reff_rin']  = $request->user_confirm_pass;
        DB::table('user_customer')->insert($data);


        return Redirect()->back()->with('success','Brand inserted successfuly');
    }

    public function Login()
    {
        # code...
        return view('pages.login');
    }

    public function MakeLogin(Request $request)
    {
        # code...
        $validated = $request->validate([
            'user_email' => 'required|email',
            'user_pass' => 'required|min:5',
        ]);

        $qry="SELECT * FROM `user_customer` WHERE `email`='$request->user_email'";
        $user_data=DB::select($qry);
        
        if($user_data){
            if(Hash::check($request->user_pass, $user_data[0]->password)){
                Session::put('login', true);
                Session::put('u_id', $user_data[0]->id);
    
                return redirect()->route('home');
            }
            else{
                return Redirect()->back()->with('regUniqError','Wrong Password!')->withInput();
            }   
        }
        else{
            return Redirect()->back()->with('regUniqError','User Not Found!')->withInput();
        }
    }

    public function MakeLoginCheckOut(Request $request)
    {
        # code...
        $validated = $request->validate([
            'user_email' => 'required|email',
            'user_pass' => 'required|min:5',
        ]);

        $qry="SELECT * FROM `user_customer` WHERE `email`='$request->user_email'";
        $user_data=DB::select($qry);
    
        if(Hash::check($request->user_pass, $user_data[0]->password)){
            Session::put('login', true);
            Session::put('u_id', $user_data[0]->id);
        }

        $this->MargeCart();

        return Redirect()->back();
    }

    public function MargeCart()
    {
        # code...

        $dbCartItems=$this->getCartItemsDB();
        $sessionCartItems=$this->getCartItemSession();

        foreach($sessionCartItems as $sItems){
            foreach($dbCartItems as $dItems){
                if($sItems->id==$dItems->id){
                    $sql="UPDATE `gen_carts` SET `qty`=".$sItems->qty." WHERE `customer_id`='".session('u_id')."' and `gen_p_id`='".$dItems->id."' and `active`='1' ";
                    DB::update($sql);
                }
                else{
                    $sql="INSERT INTO `gen_carts`(`customer_id`, `gen_p_id`, `qty`, `active`) VALUES ('".session('u_id')."','".$sItems->id."','".$sItems->qty."','1')";
                    DB::insert($sql);
                }
            }
        }

    }
    public function getCartItemsDB()
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
