<!DOCTYPE html>
<html>
<head>
<!-- <link rel="icon" type="image/png" sizes="96x96" href={{ URL::asset("images/logo.ico")}} > -->
<title>Grocivery</title>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="viewport" content= "width=device-width, user-scalable=no">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="csrf-token" content="{{ csrf_token() }}" />
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<link rel="stylesheet" href="/css/bootstrap.css">
  <script src="/js/jquery.min.js"></script>
  <script src="/js/bootstrap.min.js"></script>
  <script src="/js/html5shiv.min.js"></script>
  <script src="/js/Respond.js"></script>
  <link rel="stylesheet" href="/css/bar.css">
  <link rel="stylesheet" href="/css/w3schools.css">
  <link rel="stylesheet" href="/css/welcome.css">
<link rel="stylesheet" href="/css/slider.css">

  </head>
  @php( $home_top_titles = \App\home_top_title::all() )
    @foreach($home_top_titles as $home_top_title)
  <div class="toptext brandcolor text-center">
  <i class="fa fa-leaf"></i>
  &nbsp; {{$home_top_title->content}} &nbsp;
    <i class="fa fa-leaf"></i>

</div>
  @endforeach
  
  <!-- Start modal menu  -->
  <div class="bar">

  <div class="barIconDiv" data-toggle="modal" data-target="#myModal">
  <i class="fa fa-bars barIcon fa-lg visible-xs" ></i>
</div>
<div class="modalMenu modal fade" id="myModal" role="dialog">
   
    
      <!-- Modal content-->
      <div class="modal-content">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <br>
          <div class="content">
            <ul class="nav navbar-nav">
              <li>  
                <a href="#"><h4>HOME</h4></a> 
              </li>
              <hr>
              <li class="dropdown visible-xs">
                  <a href="#" class="dropdown-toggle " data-toggle="dropdown"
                  role="button" aria-haspopup="true" aria-expanded="false"><h4>MARKET<i class='fa fa-angle-down'></i></h4>
                  </a>
                  <ul class="dropdown-menu">
                  <li><a class="" href="{{route('shop')}}"  >
                      All products</a></li>  

                                   @php( $categories = \App\category::all() )
                @foreach($categories as $category)
                <li><a class="" href="{{route('category',['id' => $category->id])}}" >
                        {{$category->name}}</a></li>        
                  @endforeach   
                  </ul>
              </li>
              <hr>
              <li class="dropdown visible-xs">
                  <a href="#" class="dropdown-toggle " data-toggle="dropdown"
                  role="button" aria-haspopup="true" aria-expanded="false"><h4>ORGANIC MEALS<i class='fa fa-angle-down'></i></h4>
                  </a>
                  <ul class="dropdown-menu">
        
                    <li><a class="" href="{{route('ItemController.product',['num' => 0])}}"  >
                      xxx</a></li>     
                      <li><a class="" href="{{route('ItemController.product',['num' => 1])}}" >
                      xxx</a></li>     
                      <li><a class="" href="{{route('shop')}}" >
                      View all</a></li>   
                  </ul>
              </li>
              <hr>
             
              <li>
                <a href="{{route('recipes')}}" >COOKING RECIPES</a>
              </li>
              <hr>
              <li>  
                <a href="#"><h4>ORGANIC NUTRITION PLANS</h4></a> 
              </li>
              <hr>
              <li>  
                <a href="#"><h4>CONTACT US</h4></a> 
              </li>
              <hr>
              @auth
    @if(Auth::user()->type == 1)
    <li class="dropdown">
          <a href="#" class="dropdown-toggle " data-toggle="dropdown"
          role="button" aria-haspopup="true" aria-expanded="false"><h4>ACTIONS
          <i class='fa fa-angle-down'></i></h4></a>
          <ul class="dropdown-menu">
    
            <li>
              <a href="{{route('addadminview')}}">
              <i class="fa fa-plus actionicons"></i>Add Admin</a>
            </li>    
            
            <li>
              <a href="{{route('item.create')}}">
            <i class="fa fa-plus actionicons"></i>Add Item</a>
            </li>       

            <li><a href="{{route('vieworders')}}">
            <i class="fa fa-list actionicons"></i>View Orders</a>
            </li>

            <li><a href="{{route('category.edit')}}">
            <i class="fa fa-edit actionicons"></i>Edit Categories</a>
            </li>

            <li>
              <a data-toggle="modal" data-target="#addcategory">
              <i class="fa fa-plus actionicons"></i>Add Category</a>
            </li>

            <li>
              <a href="{{route('report')}}">
              <i class="fa fa-clipboard actionicons"></i>Report</a>
            </li>

            <li>
              <a href="{{route('distributor.showAll')}}">
              <i class="fa fa-list actionicons"></i>Show Distributors</a>
            </li>

            <li>
              <a href="{{route('subscribers')}}">
              <i class="fa fa-users actionicons"></i>Show Subscribers</a>
            </li>

            <li>
              <a href="{{route('contact.showAll')}}">
              <i class="fa fa-phone actionicons"></i>Manage Contacts</a>
            </li>
            <li>
              <a href="{{route('customize.showAll')}}">
              <i class="fa fa-list actionicons"></i>Show customize orders</a>
            </li>
            <li><a href="{{route('fee.showAll')}}">
            <i class="fa fa-truck actionicons"></i>Manage fees</a>
            </li>
            <li><a href="{{route('Zone.showAll')}}">
            <i class="fa fa-map-marker actionicons"></i>Manage zones</a>
            </li>
            <li><a href="{{route('home.images.showAll')}}">
            <i class="fa fa-edit actionicons"></i>Edit home page </a>
            </li>
          </ul>
    </li>
  <hr>
  
    @else
    <li>
      <a href="{{route('lastorder')}}" class=""><h4>LAST ORDER</h4></a>
</li>
<hr>



@endif
<li>
        <a href="{{ route('user.edit',['id' => Auth::user()->id]) }}" class="">
        <h4>EDIT PROFILE</h4></a>
</li>
<hr>
<li>
        <a href="{{route('logout')}}" onclick="event.preventDefault();
                document.getElementById('logout-form').submit();"><h4>LOG OUT</h4></a>
                   
    </li>
    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                        @csrf
                                    </form>
  @else
  <li>     
      <a href="{{ Request::is('login') ? route('home') : route('login') }}"><h4>LOGIN</h4></a> 
    </li>
@endauth
            </ul>
          </div>
      </diV>
      
   
  </div>

  <!-- End modal menu  -->
  <a href="{{route('welcome')}}" >
    <p class="logo title text-center">GROCIVERY</p>
  </a>
  <div class="mainBar hidden-xs">
      <ul class="nav navbar-nav ">
      <li>
        <a href="{{route('shop')}}" >HOME</a>
      </li>
<li class="dropdown">
          <a href="#" class="dropdown-toggle " data-toggle="dropdown"
          role="button" aria-haspopup="true" aria-expanded="false">MARKET
          <i class='fa fa-angle-down'></i></a>
          <ul class="dropdown-menu">
          <li><a class="" href="{{route('shop')}}"  >
                      All products</a></li>  

                                   @php( $categories = \App\category::all() )
                @foreach($categories as $category)
                <li><a class="" href="{{route('category',['id' => $category->id])}}" >
                        {{$category->name}}</a></li>        
                  @endforeach 
          </ul>
        </li>

<li class="dropdown">
          <a href="#" class="dropdown-toggle " data-toggle="dropdown"
          role="button" aria-haspopup="true" aria-expanded="false">ORGANIC MEALS
          <i class='fa fa-angle-down'></i></a>
          <ul class="dropdown-menu">
          @php( $categories = \App\category::all() )
    @foreach($categories as $category)
    <li><a class="" href="{{route('category',['id' => $category->id])}}" >
            {{$category->name}}</a></li>        
      @endforeach
          </ul>
        </li>

        <li>
          <a href="{{route('recipes')}}" >COOKING RECIPES</a>
        </li>

       
         

        @auth
        <li class="dropdown">
          <a href="#" class="dropdown-toggle " data-toggle="dropdown"
          role="button" aria-haspopup="true" aria-expanded="false">MORE
          <i class='fa fa-angle-down'></i></a>
          <ul class="dropdown-menu">
        <li>
          <a href="{{route('lastorder')}}" class="">LAST ORDER</a>
        </li>    
        <li>
        <a href="{{ route('user.edit',['id' => Auth::user()->id]) }}" class="">
            EDIT PROFILE</a></li>    

        <li>
        <a href="{{route('logout')}}" onclick="event.preventDefault();
                document.getElementById('logout-form').submit();">LOG OUT</a>            
      </li>
          </ul>
        </li>
    @if(Auth::user()->type == 1)
    <li class="dropdown">
          <a href="#" class="dropdown-toggle " data-toggle="dropdown"
          role="button" aria-haspopup="true" aria-expanded="false">ACTIONS
          <i class='fa fa-angle-down'></i></a>
          <ul class="dropdown-menu">
    
            <li>
              <a href="{{route('addadminview')}}">
              <i class="fa fa-plus actionicons"></i>Add Admin</a>
            </li>    
            
            <li>
              <a href="{{route('item.create')}}">
            <i class="fa fa-plus actionicons"></i>Add Item</a>
            </li>       

            <li><a href="{{route('vieworders')}}">
            <i class="fa fa-list actionicons"></i>View Orders</a>
            </li>

            <li><a href="{{route('category.edit')}}">
            <i class="fa fa-edit actionicons"></i>Edit Categories</a>
            </li>

            <li>
              <a data-toggle="modal" data-target="#addcategory">
              <i class="fa fa-plus actionicons"></i>Add Category</a>
            </li>

            <li>
              <a href="{{route('report')}}">
              <i class="fa fa-clipboard actionicons"></i>Report</a>
            </li>

            <li>
              <a href="{{route('distributor.showAll')}}">
              <i class="fa fa-list actionicons"></i>Show Distributors</a>
            </li>

            <li>
              <a href="{{route('subscribers')}}">
              <i class="fa fa-users actionicons"></i>Show Subscribers</a>
            </li>

            <li>
              <a href="{{route('contact.showAll')}}">
              <i class="fa fa-phone actionicons"></i>Manage Contacts</a>
            </li>
            <li>
              <a href="{{route('customize.showAll')}}">
              <i class="fa fa-list actionicons"></i>Show customize orders</a>
            </li>
            <li><a href="{{route('fee.showAll')}}">
            <i class="fa fa-truck actionicons"></i>Manage fees</a>
            </li>
            <li><a href="{{route('Zone.showAll')}}">
            <i class="fa fa-map-marker actionicons"></i>Manage zones</a>
            </li>
            <li><a href="{{route('home.images.showAll')}}">
            <i class="fa fa-edit actionicons"></i>Edit home page </a>
            </li>
          </ul>
    </li>
  
  
    <!-- <li>
      <a href="{{route('lastorder')}}" class="">LAST ORDER</a>
</li>

 -->


@endif
<!-- <li>
        <a href="{{ route('user.edit',['id' => Auth::user()->id]) }}" class="">
        EDIT PROFILE</a>
</li>

<li>
        <a href="{{route('logout')}}" onclick="event.preventDefault();
                document.getElementById('logout-form').submit();">LOG OUT</a>
                   
    </li> -->
    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                        @csrf
                                    </form>
  @else
  <li>     
      <a href="{{ Request::is('login') ? route('home') : route('login') }}">LOGIN</a> 
    </li>
@endauth

</ul>
    </div>
  </div>
  <hr>
   
  @auth
@if(Auth::user()->type == 1)
@include('addcategory')
@endif
@endauth
  </div>
  <hr>
    <!-- End main bar -->

<script type="text/javascript" src="{{ URL::asset('js/slider.js') }}"></script>



<!-- Start Subscribe -->
 <form class="form-inline Subscribe center-block" id="subscribe">
 <h3 class=" title text-center"> SUBSCRIBE</h3>
    <div class="form-group">
      <input type="email" class="SubscribeInput" id="email" placeholder="Email" name="email">
    </div>

    <button type="submit" class="buttons brandcolor">SIGN UP</button>
    @error('email')
      <br>

                                     <span role="alert" style="color:red;">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror 
  </form>
  <!-- End Subscribe -->
<br>
<br>

    <!-- Start slider -->
  <h3 class=" title text-center">PHOTO GALLERY</h3>

  <div class="gallery js-flickity"
  data-flickity-options='{ "wrapAround": true }'>

    <div class="gallery-cell">
      <img src={{ URL::asset("images/21596.jpg")}}>
    </div>

    <div class="gallery-cell">
      <img src={{ URL::asset("images/24282.png")}}>
    </div>
    
    <div class="gallery-cell">
      <img src={{ URL::asset("images/21961.jpeg")}}>
    </div>    
    
    <div class="gallery-cell">
      <img src={{ URL::asset("images/21753.jpeg")}}>
    </div>
    
    <div class="gallery-cell">
      <img src={{ URL::asset("images/77138.jpg")}}>
    </div>
  </div>
  <!-- End slider -->
<div class="shop-now-section">
  <p class="text-center">A FRESH, HANDCRAFTED PRODUCT THAT’S DELIVERED WITH PASSION!</p>
  <a class="" href="{{route('shop')}}"  >
  <button class="buttons brandcolor center-block">SHOP NOW</button>
  </a>
</div>

<!-- Start about us section -->
<div class="aboutus">

  <img src={{ URL::asset("images/58693.jpeg")}}>
<div>
  <p class="title text-center">ABOUT US</p>
  <p>ONLINE GROCERY SHOPPING</p>
  <p>MAIN CATEGORY</p>
  <p>Fresh Fruits, Vegetables & Herbs</p>
  <p>WE GUARANTEE</p>
  <ul>
    <li>A fresh products picked one-by-one.</li>
    <li>A multiple cleaning stages for the products.</li>
    <li>Hand-Free treatment after cleaning.</li>
    <li>100% Healthy materials for packaging.</li>
    <li>A clean delivery directly to your home door.</li>
  </ul>
  <p>WE OFFER</p>
  <ul>
    <li>A fresh products picked one-by-one.</li>
    <li>A multiple cleaning stages for the products.</li>
    <li>Hand-Free treatment after cleaning.</li>
    <li>100% Healthy materials for packaging.</li>
    <li>A clean delivery directly to your home door.</li>
  </ul>

  <p>AREAS WE COVER</p>
  <ul>
    <li>Nasr City</li>
    <li>Heliopolis</li>
  </ul>
</div>
</div>
<!-- End about us section -->
<!-- <a href="{{route('cart')}}">
  <button class="btn-cart brandcolor"><i class="fa fa-shopping-cart fa-3x"></i></button>
</a> -->

<div class="wrapper">
<a href="{{route('cart')}}">
  <button class="btn-cart brandcolor"><i class="fa fa-shopping-cart fa-3x"></i></button>
      <span class="badge countCart" id='countcart'>@if(session()->has('number_of_items')){{Session::get('number_of_items')}}@endif</span>
      </a> 
    </div>

  @include('errormessage')

  <script type="text/javascript">


    $.ajaxSetup({

        headers: {

            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')

        }

    });
  $('#subscribe').on('submit',function(event){
    event.preventDefault();

    email = $('#email').val();

    $.ajax({
      url: "{{route('createSubscriber')}}",
      type:"POST",
      data:{       
        email:email,
      },
      success:function(response){
        $("#email").val('');
        $('#messaga').text(response.success)
        $('#errormessage').modal();

      },
     });
    });
 

  </script>
</body>