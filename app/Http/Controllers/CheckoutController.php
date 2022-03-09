<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;


class CheckoutController extends Controller
{
    //
    public function Checkout()
    {
        # code...
        if(Session::get('login')){
            $cartItems=$this->getCartItemsDB();
        }
        else{
            $cartItems=$this->getCartItemSession();
        }

        $shopId=$this->GetCartShop();
        $shopDelCharge=$this->GetDeliveryCharge($shopId);
        $custData=$this->getUserBillData();

        return view('checkout.index',compact('cartItems','shopDelCharge','custData'));
    }

    public function finalCheckout(Request $request)
    {
        # code...
        
        $this->checkoutValidate($request);

        $billName=$request->billName;
        $billMobileNo=$request->billMobileNo;
        $billAddress=$request->billAddress;
        $billDistrict=$request->billDistrict;
        $billThana=$request->billThana;
        $reffNo=$request->reffNo;
        $password=$request->password;
        $cPassword=$request->cPassword;
        $delName=$request->delName;
        $delMobile=$request->delMobile;
        $delAddress=$request->delAddress;
        $delDistrict=$request->delDistrict;
        $delThana=$request->delThana;
        $orderNote=$request->orderNote;


        if(strlen($delName)==0 or strlen($delMobile)==0 or strlen($delAddress)==0){
            $delName=$billName;
            $delMobile=$billMobileNo;
            $delAddress=$billAddress;
            $delDistrict=$billDistrict;
            $delThana=$billThana;
        }

        

        $custId=null;
        $storeId=$this->GetCartShop();
        $delCharge=$this->GetDeliveryCharge($storeId);

        
        if($this->CheckDelDistrict($delDistrict,$storeId)==0){
            return Redirect()->back()->with('regUniqError','This shop does not deliver to your district')->withInput();
        }

        $cartItems=array();

        $lastInvSql="SELECT date(`date_time`) as invDate, `invoice` FROM `gen_orders` WHERE `id`= (select MAX(id) from gen_orders where 1);";
        $lastInvData=DB::select($lastInvSql);

        $oldInvDate=$lastInvData[0]->invDate;
        $oldInv=$lastInvData[0]->invoice;

        $invoice="";
        if(date("Y-m-d")==$oldInvDate){
            $oldInv=substr($oldInv,8);
            $oldInv++;
            $invoice="AD".date("ymd").$oldInv;
        }
        else{
            $invoice="AD".date("ymd")."1001";
        }
        if(session('u_id')){
            $custId=session('u_id');
        }

        $invId = DB::table('gen_orders')->insertGetId(array(
            'invoice' => $invoice,
            'cust_id' => $custId,
            'store_id' => $storeId,
            'bill_name' => $billName,
            'bill_mobile' => $billMobileNo,
            'bill_address' => $billAddress,
            'bill_district' => $billDistrict,
            'bill_thana' => $billThana,
            'ship_name' => $delName,
            'ship_mobile' => $delMobile,
            'ship_address' => $delAddress,
            'ship_district' => $delDistrict,
            'ship_thana' => $delThana,
            'ship_note' => $orderNote,
            'del_type' => "cod",
            'pay_type' => "cod",
            'status' => "pending",
            'reff_rin' => $reffNo,
            'abl_comission' => "0",
            'com_pay_stat' => "pending",
            'odc_no' => "",
            'del_charge' => $delCharge
        ));
        
        if(Session::get('u_id')){
            $cartItems=$this->getCartItemsDB();
        }
        else{
            $cartItems=$this->getCartItemSession();
        }
        
        $totalComiision=0;
        foreach($cartItems as $item){
            $data=$this->GetOrderItemData($item->id);

            $totalComiision+=($data->commisionAmnt*$item->qty);

            $custId = DB::table('gen_ord_items')->insertGetId(array(
                'invoice' => $invId,
                'store_p_id' => $item->id,
                'unit_mrp' => $data->uMrp,
                'unit_sale' => $data->salePrice,
                'qty' => $item->qty,
                'abl_com_percentage' => (($data->commisionAmnt*100)/$data->salePrice),
                'abl_comission' => $data->commisionAmnt*$item->qty
            ));
        }

        $sql="UPDATE `gen_orders` SET `abl_comission`='$totalComiision' WHERE `id`='$invId'";
        DB::update($sql);
        if(Session::get('u_id')){
            $sql="UPDATE `gen_carts` SET `active`='0' WHERE customer_id=".Session::get('u_id')."";
            DB::update($sql);
        }
        else{
            Session::forget('cart');
            $cartInfo['number']=0;
            session()->put('cartInfo',$cartInfo);
        }

        $this->getCartInfo();

        $url="/checkoutInvoice/".$invId;
        return Redirect::to($url);
    }
    // $qry="SELECT COUNT(`mobile`) as 'dup' FROM `user_customer` WHERE mobile='".$request->user_mobile."'";
    // $count_mobile=DB::select($qry);
    // if($count_mobile[0]->dup>0){
    //     $mobileUnqError++;
    // }
    // if($mobileUnqError>0){
    //     return Redirect()->back()->with('regUniqError','Mobile is Already Exist!')->withInput();
    // }
    public function CheckDelDistrict($district,$shopId)
    {
        # code...
        $sql="SELECT `district` FROM `user_seller` WHERE `id`='$shopId'";
        $data=DB::select($sql);

        // var_dump($district);
        // var_dump($data);
        // die;

        if($district != $data[0]->district){
            return 0;
        }
        else{
            return 1;
        }
    }
    public function getUserBillData(){
        $billName="";
        $billMobile="";
        $billAddress="";
        $reff="";

        if(Session::get('u_id')){
            $sql="SELECT `name`,`mobile`, `billing_address`,`reff_rin` FROM `user_customer` WHERE `id`=".Session::get('u_id')."";
            $custData=DB::select($sql);
            
            
            $billName=$custData[0]->name;
            $billMobile=$custData[0]->mobile;
            $billAddress=$custData[0]->billing_address;
            $reff=$custData[0]->reff_rin;
        }

        if($reff=="" or $reff==null or strlen($reff)==0){
            $storeId=$this->GetCartShop();
            $sql="SELECT `rin` FROM `user_seller` WHERE `id`='$storeId'";
            $data=DB::select($sql);

            if($data){
                $reff=$data[0]->rin;
            }
            else{
                $reff="";
            }
        }

        $custData=(object) array(
            "billName"=> $billName,
            "billMobile"=> $billMobile,
            "billAddress"=> $billAddress,
            "reff"=>$reff
        );

        // var_dump($custData);
        // die;
        return $custData;
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

    public function GetOrderItemData($storPId)
    {
        # code...
        $sql="SELECT store_products.id as store_pId, products.unit_mrp as uMrp, store_products.sale_price as salePrice,store_products.abl_com_amnt as commisionAmnt
        FROM `store_products`,`products` 
        WHERE 
        store_products.prod_id=products.id AND
        store_products.id='$storPId'";
        $data=DB::select($sql);

        return $data[0];
    }
    public function checkoutValidate($req)
    {
        # code...
        $validated = $req->validate([
            'billName' => 'required',
            'billAddress' => 'required',
            'billDistrict' => 'required', 
            'billThana' => 'required',
            'cPassword' => 'same:password'
        ]);

        
        // if($req->delMobile!=null){
        //     if($req->delName == null){
        //         return Redirect::back()->with('delNameError','Name is Required')->withInput();;
        //     }
        //     if($req->delAddress == null){
        //         return Redirect::back()->with('delAddressError','Address is Required')->withInput();;
        //     }
        //     if($req->delDistrict == null){
        //         return Redirect::back()->with('delDistrictError','District is Required')->withInput();;
        //     }
        //     if($req->delThana == null){
        //         return Redirect::back()->with('delThanaError','Thana is Required')->withInput();;
        //     }
        // }

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
        gen_carts.active='1'";

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
    public function GetCartShop(){
        #get products item from cart, if logged in then get from db else session, then cheak the product shop  id and return that.
        if(Session::get('login')){
            $sql="SELECT store_products.store_id as storeId
            FROM `gen_carts`,`store_products` 
            WHERE 
            gen_carts.gen_p_id=store_products.id AND
            gen_carts.customer_id='".session('u_id')."'";

            $result=DB::select($sql);

            if(count($result)==0){
                return null;
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
            
            
            if(count($result)==0){
                return null;
            }
            else{
                return $result[0]->store_id;            
            } 
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
        return $data[0]->del_charge;
    }
}
