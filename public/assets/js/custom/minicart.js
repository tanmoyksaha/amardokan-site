$(document).ready(function(){
    // http://127.0.0.1:8003/mini-cart-data
    var link=$('#miniCartLinkTable').val();
    var linkSum=$('#miniCartLinkSum').val();
    $.ajax({
        url: link,
        type: "GET",
        success: function(result){
            $("#mini-cart-list").html(result);
        },
        error: function (jqXHR, textStatus, errorThrown){
            alert(JSON.stringify(jqXHR)+""+errorThrown+" "+textStatus);
        }
    });
    $.ajax({
        url: linkSum,
        type: "GET",
        success: function(result){
            $("#mini_cart_table").html(result);
        },
        error: function (jqXHR, textStatus, errorThrown){
            alert(JSON.stringify(jqXHR)+""+errorThrown+" "+textStatus);
        }
    });

}); 