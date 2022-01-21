<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>Aamardokan</title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    @include('library.head')
</head>
<body>
    @include('library.offCanvasMenue')
    <header>
        <div class="main_header">
         
            @include('library.topNav')
            @include('library.mainNav')
        
        </div> 
    </header>
    <!--header area end-->
    

    @yield('main_content')

    
    <!--footer area start-->
    <footer class="footer_widgets ">
        @include("library.footer")
    </footer>
    <!--footer area end-->
    
    <!-- Js -->
        @include("library.foot")

        @yield('js')
</body>

</html>