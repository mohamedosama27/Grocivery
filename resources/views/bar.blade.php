@extends('addcategory')
<!DOCTYPE html>
<html>
<title>LOGO</title>
<meta charset="UTF-8">

<meta name="viewport" content="width=device-width, initial-scale=1">
<link href="{{ asset('css/app.css') }}" rel="stylesheet">

<link rel="stylesheet" href="{{ asset('css/w3schools.css') }}">
<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto">
<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Montserrat">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
<style>
.w3-sidebar a {font-family: "Roboto", sans-serif}
body,h1,h2,h3,h4,h5,h6,.w3-wide {font-family: "Montserrat", sans-serif;}
.wrapper{
position: relative;
}
.wrapper .countCart{
position: absolute;
top: -2px;
right: -2px; 
}
.countCart{
  background-color:red;
}
body{
  margin-top:70px;
}
</style>
<body class="w3-content" style="max-width:1200px;">

<!-- Sidebar/menu -->
<nav class="w3-sidebar w3-bar-block w3-white w3-collapse w3-top" style="z-index:3;width:250px" id="mySidebar">
  <div class="w3-container w3-display-container w3-padding-16">
    <i onclick="w3_close()" class="fa fa-remove w3-hide-large w3-button w3-display-topright"></i>
    <h3 class="w3-wide"><b>LOGO</b></h3>
  </div>
  <div class="w3-padding-64 w3-large w3-text-grey" style="font-weight:bold">
    <a href="{{route('home')}}" class="w3-bar-item w3-button"><i class="fa fa-home" style="margin-right:5px;"></i>Home</a>
    @auth
    @if(Auth::user()->type == 1)
    <a href="{{route('item.create')}}" class="w3-bar-item w3-button"><i class="fa fa-plus" style="margin-right:5px;"></i>Add Item</a>
    <a data-toggle="modal" data-target="#addcategory" class="w3-bar-item w3-button"><i class="fa fa-plus" style="margin-right:5px;"></i>Add Category</a>

@endif
@endauth

    <a onclick="myAccFunc()" href="javascript:void(0)" class="w3-button w3-block w3-white w3-left-align" id="myBtn">
    <i class='fa fa-product-hunt'></i> Products <i class="fa fa-caret-down"></i>
    </a>
    <div id="demoAcc" class="w3-bar-block w3-hide w3-padding-large w3-medium">
    @php( $categories = \App\category::all() )
    @foreach($categories as $category)
      <a href="#" class="w3-bar-item w3-button w3-light-grey"><i class="fa fa-caret-right w3-margin-right"></i>{{$category->name}}</a>
     
      @endforeach
    </div>
    <a href="#" class="w3-bar-item w3-button">
      <i class='fa fa-phone' style="margin-right:5px;">
    </i>Contact</a>
    <a href="javascript:void(0)" class="w3-bar-item w3-button" onclick="document.getElementById('newsletter').style.display='block'">
    <i class="fa fa-envelope" style="margin-right:5px;"></i>Mail Us</a> 
  </div>
  
</nav>

<!-- Top menu on small screens -->
<header class="w3-bar w3-top w3-black w3-xlarge" style="margin-bottom:30px;">
  <div class="w3-bar-item w3-padding-24 w3-wide">LOGO</div>
  <a href="javascript:void(0)" class="w3-bar-item w3-button w3-padding-24 w3-right" onclick="w3_open()"><i class="fa fa-bars"></i></a>
  <a href="{{ Request::is('cart') ? route('home') : route('cart') }}" class="w3-bar-item w3-button w3-padding-24 w3-right" >
  <div class="wrapper">
  <i class="fa fa-shopping-cart w3-margin-right"></i>
  <span class="badge countCart" >{{Session::has('number_of_items') ? Session::get('number_of_items'): ''}}</span>
  </div>
  </a>
  @guest
                            
                                <a class="w3-bar-item w3-button w3-padding-24 w3-right" href="{{ Request::is('login') ? 'home' : 'login' }}"><i class="fa fa-sign-in" style="margin-right:5px;"></i></a>
                                @else
                            <div class="nav-item dropdown">
                                <a id="navbarDropdown" class="w3-bar-item w3-button w3-padding-24 w3-right" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                <i class="fa fa-user" ></i> <span class="caret"></span>
                                </a>

                                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item" href="{{ route('logout') }}"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                        {{ __('Logout') }}
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                        @csrf
                                    </form>
                                </div>
</div>
                        @endguest
                            <!-- @if (Route::has('register'))
                               
                                    <a class="w3-bar-item w3-button" href="{{ route('register') }}"></a>
                                
                            @endif -->
                   
</header>

<!-- Overlay effect when opening sidebar on small screens -->
<div class="w3-overlay w3-hide-large" onclick="w3_close()" style="cursor:pointer" title="close side menu" id="myOverlay"></div>
<div class="w3-main" style="margin-left:250px">

  <!-- Push down content on small screens -->
  <div class="w3-hide-large" style="margin-top:83px"> </div>
  @yield('content')

 







</div>



<script>
// Accordion 
function myAccFunc() {
  var x = document.getElementById("demoAcc");
  if (x.className.indexOf("w3-show") == -1) {
    x.className += " w3-show";
  } else {
    x.className = x.className.replace(" w3-show", "");
  }
}

// Click on the "Jeans" link on page load to open the accordion for demo purposes
document.getElementById("myBtn").click();


// Open and close sidebar
function w3_open() {
  document.getElementById("mySidebar").style.display = "block";
  document.getElementById("myOverlay").style.display = "block";
}
 
function w3_close() {
  document.getElementById("mySidebar").style.display = "none";
  document.getElementById("myOverlay").style.display = "none";
}
</script>
</body>
</html>
