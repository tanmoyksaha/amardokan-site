<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Print Voucher</title>
    <style>
        @page
        {
            size: A4;
            margin: 0;
        }
        @media print {
                html, body {
                    height:100vh; 
                    margin: 0 !important; 
                    padding: 0 !important;
                    overflow: hidden;
                }
                
        }    
    </style>
</head>
<body>
    <div class="container invoice-invoice border border-primary mt-2">
        <div class="row mt-4 mx-4">
            <div class="col-12">
                <div class="row">
                    <div class="col-6">
                        Invoice No: <span class="invoice-invoice-no">{{ $resultInv[0]->invoice }}</span>
                    </div>
                    <div class="col-6 invoice-invoice-text-right">
                        <span class="invoice-invoice-no">{{ $resultInv[0]->date_time }}</span>
                    </div>
                </div>
                <div class="row">
                    <div class="col-2">
                        @php
                            $storLogo=env('ADMIN_PANEL')."images/shop_banner/".$resultInv[0]->store_id.".png";
                        @endphp
                        <img src="{{ $storLogo }}" class="img-fluid border">
                    </div>
                    <div class="col-10">
                        <div class="row">
                            <span class="invoice-powered-by">Powered By</span>
                        </div>
                        <div class="row">
                            @php
                                $logoUrl=env('SITE_URL').'assets/logo/logo.png';
                            @endphp
                            <img src="{{ $logoUrl }}" class="invoice-platform-logo">
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row mt-2 ">
            <div class="col-12">
                <div class="row">
                    <div class="col-6">
                        <div class="row">
                            <div class="col border invoice-field">Invoice No: </div>
                            <div class="col border invoice-field invoice-invoice-text-left">{{ $resultInv[0]->invoice }}</div>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="row">
                            <div class="col border invoice-field">Payment Method: </div>
                            <div class="col  border invoice-field invoice-invoice-text-left">{{ $resultInv[0]->pay_type }}</div>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="row">
                            <div class="col border invoice-field">Order Date: </div>
                            <div class="col border invoice-field invoice-invoice-text-left">{{ $resultInv[0]->date_time }}</div>
                        </div>
                    </div>
                    <div class="col-6 border">
                        
                    </div>
                </div>
                <div class="row">
                    <div class="col-6">
                        <div class="row">
                            <div class="col border invoice-field">Bill To: </div>
                            <div class="col border invoice-field invoice-invoice-text-left">{{ $resultInv[0]->bill_name }}</div>
                        </div>
                        <div class="row border">
                            <div class="col  invoice-field">Address: </div>
                            <div class="col border invoice-field invoice-invoice-text-left">
                                <p>{{ $resultInv[0]->bill_address }}</p>    
                            </div>
                        </div>
                        <div class="row">
                            <div class="col border invoice-field">Phone: </div>
                            <div class="col border invoice-field invoice-invoice-text-left">{{ $resultInv[0]->bill_mobile }}</div>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="row">
                            <div class="col border invoice-field">Deliver To: </div>
                            <div class="col border invoice-field invoice-invoice-text-left">{{ $resultInv[0]->ship_name }}</div>
                        </div>
                        <div class="row border">
                            <div class="col  invoice-field">Address: </div>
                            <div class="col border invoice-field invoice-invoice-text-left">
                                <p>{{ $resultInv[0]->ship_address }}</p>    
                            </div>
                        </div>
                        <div class="row">
                            <div class="col border invoice-field">Phone: </div>
                            <div class="col border invoice-field invoice-invoice-text-left">{{ $resultInv[0]->ship_mobile }}</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row mt-3">
            <div class="col-12">
                <div class="row border">
                    <div class="col-12 invoice-field">
                        Your Order Items
                    </div>
                </div>
                <div class="row text-center">
                    <div class="col border invoice-field field-bold">
                        NO
                    </div>
                    <div class="col border invoice-field field-bold">
                        Product Name
                    </div>
                    <div class="col border invoice-field field-bold">
                        Unit Sale Price
                    </div>
                    <div class="col border invoice-field field-bold">
                        QTY
                    </div>
                    <div class="col border invoice-field field-bold">
                        Total 
                    </div>
                </div>
                @php $subTotal=0; @endphp
                @foreach($resultProduct as $item)
                @php $subTotal=$subTotal+($item->unit_sale*$item->qty) @endphp
                <div class="row text-center">
                    <div class="col border invoice-field">
                        {{ $loop->iteration }}
                    </div>
                    <div class="col border invoice-field">
                        {{ $item->pName }}
                    </div>
                    <div class="col border invoice-field">
                        {{ $item->unit_sale }}
                    </div>
                    <div class="col border invoice-field">
                        {{ $item->qty }}
                    </div>
                    <div class="col border invoice-field">
                        {{ $item->unit_sale*$item->qty }}
                    </div>
                </div>
                @endforeach
            </div>
        </div>

        <div class="row mt-3">
            <div class="col-12">
                <div class="row">
                    <div class="col-10 invoice-invoice-text-right border invoice-field">Sub Total</div>
                    <div class="col-2 invoice-invoice-text-right border invoice-field">{{ $subTotal }}</div>
                </div>
                <div class="row">
                    <div class="col-10 invoice-invoice-text-right border invoice-field">Shipping Cost</div>
                    <div class="col-2 invoice-invoice-text-right border invoice-field">{{ $shopDCharge }}</div>
                </div>
                <div class="row">
                    <div class="col-10 invoice-invoice-text-right border invoice-field">Total</div>
                    <div class="col-2 invoice-invoice-text-right border invoice-field">{{ $subTotal+$shopDCharge }}</div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>