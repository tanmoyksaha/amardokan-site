<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class CampaignController extends Controller
{
    //
    public function index($campaignName)
    {
        # code...
        $sql="SELECT `store_id` as id
        FROM `campaign` 
        WHERE 
        `campaign_name`='$campaignName' AND
        `active`='1'
        GROUP BY store_id;";

        $shopData=DB::select($sql);

        return view('campaign.index',compact('shopData','campaignName'));
    }

    public function shopView($shopId,$campaignName)
    {
        # code...
        $sql="SELECT store_products.id as store_p_id,
            products.id as product_id, 
            store_products.sale_price,
            store_products.abl_com_amnt,
            store_products.stock,
            store_products.store_enlist,
            products.title as product_name,
            products.unit_mrp,
            products.status as product_status 
        
        FROM `store_products`,products,campaign 
        where products.status='active' and 
        store_products.store_enlist=1 and 
        store_products.prod_id=products.id and 
        store_products.store_id='".$shopId."' AND
        campaign.store_id=store_products.store_id and
        campaign.store_p_id=store_products.id AND
        campaign.campaign_name='".$campaignName."'";
        
        $products=DB::select($sql);
        return view('campaign.shopView',compact('shopId','products','campaignName'));
    }
}
