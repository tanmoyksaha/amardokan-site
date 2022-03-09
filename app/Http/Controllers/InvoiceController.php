<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class InvoiceController extends Controller
{
    //
    public function CheckoutInv($invId)
    {
        # code...
        $sql="SELECT `date_time`, `invoice`, `cust_id`, `store_id`, `bill_name`, `bill_mobile`, `bill_address`, `bill_district`, `bill_thana`, `ship_name`, `ship_mobile`, `ship_address`, `ship_district`, `ship_thana`, `ship_note`, `del_type`, `pay_type`, `status`, `reff_rin`, `abl_comission`, `com_pay_stat`, `odc_no`, `del_charge` FROM `gen_orders` WHERE `id`='$invId'";

        $resultInv=DB::select($sql);

        $sql="SELECT products.title as pName, gen_ord_items.`store_p_id`, gen_ord_items.`unit_mrp`, gen_ord_items.`unit_sale`, gen_ord_items.`qty`, gen_ord_items.`abl_com_percentage`, gen_ord_items.`abl_comission` 
        FROM `gen_ord_items`,`products`,store_products
        WHERE 
        gen_ord_items.invoice=$invId AND
        gen_ord_items.store_p_id=store_products.id AND
        products.id=store_products.prod_id";

        $resultProduct=DB::select($sql);

        $shopDCharge=$this->GetDeliveryCharge($resultInv[0]->store_id);


        return view('invoice.index',compact('resultInv','resultProduct','invId','shopDCharge'));
    }
    
    public function PrintCheckoutInv($invId){
        $sql="SELECT `date_time`, `invoice`, `cust_id`, `store_id`, `bill_name`, `bill_mobile`, `bill_address`, `bill_district`, `bill_thana`, `ship_name`, `ship_mobile`, `ship_address`, `ship_district`, `ship_thana`, `ship_note`, `del_type`, `pay_type`, `status`, `reff_rin`, `abl_comission`, `com_pay_stat`, `odc_no`, `del_charge` FROM `gen_orders` WHERE `id`='$invId'";

        $resultInv=DB::select($sql);

        $sql="SELECT products.title as pName, gen_ord_items.`store_p_id`, gen_ord_items.`unit_mrp`, gen_ord_items.`unit_sale`, gen_ord_items.`qty`, gen_ord_items.`abl_com_percentage`, gen_ord_items.`abl_comission` 
        FROM `gen_ord_items`,`products`,store_products
        WHERE 
        gen_ord_items.invoice=$invId AND
        gen_ord_items.store_p_id=store_products.id AND
        products.id=store_products.prod_id";

        $resultProduct=DB::select($sql);

        $shopDCharge=$this->GetDeliveryCharge($resultInv[0]->store_id);


        return view('invoice.printInvoiceCheckout',compact('resultInv','resultProduct','invId','shopDCharge'));
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
