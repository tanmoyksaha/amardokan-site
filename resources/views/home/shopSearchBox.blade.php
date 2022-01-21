<div class="home3_bg_area ">
    <form action="{{ route('home.shop.search') }}" method="post">
        @csrf
        <div class="row mx-4 text-muted">
                <div class="col-12 col-lg-3 col-md-3 p-2 ">
                    <select name="district" class=" border filter-box border-warning form-control text-center shop_search_text"  id="district">
                        <option selected>Select District</option>
                        <option value="1">Dhaka</option>
                        <option value="2">Narayanganj</option>
                        <option value="3">Noakhali</option>
                    </select>
                </div>
                <div class="col-12 col-lg-3 col-md-3 p-2 ">
                    <select name="thana" class=" border filter-box border-warning form-control text-center shop_search_text"  id="thana">
                        <option selected>Select Thana</option>
                        <option class="text-danger">Please Select District First</option>
                    </select>
                </div>
                <div class="col-12 col-lg-3  col-md-3 p-2" hidden>
                    <input name="shopArea" class="border filter-box border-warning form-control text-center " placeholder="Enter Area"  id="exampleSelect2"/>
                </div>
                <div class="col-12 col-lg-4 col-md-4 p-2">
                    <input name="shopName" class="border filter-box border-warning form-control text-center " placeholder="Enter Shop Name"  id="exampleSelect2"/>
                </div>
                <div class="col-12 col-lg-2 col-md-2 p-2">
                    <button type="submit" class="btn btn-dark  filter-box border-warning  form-control text-center text-white font-weight-bold"  id="exampleSelect2">
                        Filter
                    </button>
                </div>  
        </div>
    </form>               
</div>
<script>
    
    $(document).ready(function() {

        //District list
        $('#district').html('<option default>Select District</option>');

        var api="https://portal2.amarbazarltd.com/ablApi/getDistrict.php?username=ablapi@abl.com&password=1fa960236a09c331615f60afabd0e7e7ffa3f7d508e520d06ea566490c418c67";
        $.ajax({  
            url:api, 
            type : "GET",                                  				
            success : function(result) {
                $.each(result, function(key, val){
                    $('#district').append('<option>'+val+'</option>');
                });
            }
        });

        $('#district').on('change', function() {
            $('#thana').html('<option default>Select Thana</option>');

            var dist=$('#district').val();
            var api="https://portal2.amarbazarltd.com/ablApi/getThana.php?xdistrict="+dist+"&username=ablapi@abl.com&password=1fa960236a09c331615f60afabd0e7e7ffa3f7d508e520d06ea566490c418c67";
            $.ajax({  
                url:api, 
                type : "GET",                                  				
                success : function(result) {
                    $.each(result, function(key, val){
                        $('#thana').append('<option>'+val+'</option>');
                    });
                }
            });
        });
    });

</script>