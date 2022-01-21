<div id="#homeSlder" class="slider_area owl-carousel container">
    <div class="single_slider d-flex align-items-center shadow-sm img-fluid">
        <!-- <img src="assets/slider/slider-1.jpg" class="img-fluid" alt="" srcset=""> -->
        <img src="{{ asset('assets/slider/slider-1.jpg') }}" class="img-fluid" alt="" srcset="">
    </div>
    <div class="single_slider d-flex align-items-center img-fluid">
        <img src="{{ asset('assets/slider/slider-2.jpg') }}" alt="" srcset="">
    </div>
    <div class="single_slider d-flex align-items-center img-fluid">
        <img src="{{ asset('assets/slider/slider-3.jpg') }}" alt="">
    </div>
    <div class="single_slider d-flex align-items-center img-fluid">
        <img src="{{ asset('assets/slider/slider-4.jpg') }}" alt="">
    </div>
</div>

@section('js')
<script>
    
    $(document).ready(function(){
        $("#homeSlder").slick({
            interval: 1
        });
    }); 
</script>
@endsection