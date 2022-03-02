$( document ).ready(function() {
    // console.log( "ready!" );
    var  purchase_price=$('#purchase_price').val();
    var seller_price=$('#seller_price').val();
    var txn_cost=seller_price*(1.8/100);
    var del_charge=$('#del_charge').val();
    var vat=(seller_price-purchase_price)*(5/100);
    var b2b_margin=0;

    calBTB();
    $('#purchase_price').blur(function(){
        purchase_price=$('#purchase_price').val();
        calVat();
    });

    $('#seller_price').blur(function(){
        seller_price=$('#seller_price').val();
        callTxn();
        calVat();
    });
    $('#del_charge').blur(function(){
        del_charge=$('#del_charge').val();
        calBTB();
    });

    function callTxn()
    {
        txn_cost=seller_price*(1.8/100);
        $("#txn_cost").val(txn_cost.toFixed(2));

    }
    function calVat()
    {
        vat=seller_price-purchase_price;
        vat=vat*(5/100);
        $("#vat").val(vat.toFixed(2));
        calBTB();
    }
    function calBTB()
    {
        del_charge=Number(del_charge);
        profit=seller_price-purchase_price;
        otherCost=vat+txn_cost+del_charge;
        b2b_margin=profit-otherCost;

        $("#b2b_margin").val(b2b_margin.toFixed(2));

    }
});