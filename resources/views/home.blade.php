@extends('bar')

@section('content')
<style>
.EGP{
  margin-left:5px;
  font-size:12px;
  display:inline;
}
.column {
  float: left;
  width: 25%;
 
}
.column1 {
  float: left;
  width: 75%;
 
}
.fa-heart{
  margin-left:-3px;
  font-size:18px;
  color:red;
  
  }
  .actionIcons{
    margin-left:-5px;
    font-size:18px;


  }
  .actions{
    width:22%;
  }
</style>
<meta http-equiv="X-UA-Compatible" content="IE=edge">

<meta name="csrf-token" content="{{ csrf_token() }}" />

<link rel="stylesheet" href="/css/home.css">


<br>

 
  <div id="myCarousel" class="carousel slide" data-ride="carousel">



  <div class="carousel-inner">
    <div class="item active">
      <img src={{ URL::asset("images/cover1.jpg")}} width="100%">
    </div>

    <div class="item">
      <img src="{{ URL::asset("images/94443.jpg")}}" width="100%">
    </div>

    <div class="item">
      <img src="{{ URL::asset("images/91710.png")}}" width="100%" >
    </div>
  </div>

  <a class="carousel-control-prev left carousel-control" href="#myCarousel" role="button" data-slide="prev">
        <span class="carousel-control-prev-icon"></span>
</a>
<a class="carousel-control-next right carousel-control" href="#myCarousel" role="button" data-slide="next">
        <span class="carousel-control-next-icon"></span>
</a>

</div>
<br>
  <input type="text" name="search" id="search" class="form-control" placeholder="Search by name" />
  <input type="number" id="countitems" value="{{count($items)}}"hidden/>
<div class="cardspace">

  <div>
  

<section class="items endless-pagination" @if(count($items)>10) data-next-page="{{ $items->nextPageUrl() }}" @endif>
    @foreach($items as $item)

<div class="w3-col l3 s6 ">
      <div class="w3-container div3">
      
  <div id="myCarousel{{$item->id}}" class="carousel slide" data-ride="carousel" data-interval="false" >
   
 
    
    <div class="carousel-inner div1" >
    

    @foreach($item->images as $image)

    @if ($loop->first)
    <div class="item active" >
    <a href="{{route('item.show',['id' => $item->id])}}"> <img src={{ URL::asset("images/{$image->name}")}}></a>
      </div>    
     @else
      <div class="item">
      <a href="{{route('item.show',['id' => $item->id])}}"> 
         <img src={{ URL::asset("images/{$image->name}")}}></a>
        
      </div>
      

      @endif
      @endforeach
      

   
    </div>
    <a class="carousel-control-prev left carousel-control" href="#myCarousel{{$item->id}}" role="button" data-slide="prev">
        <span class="carousel-control-prev-icon"></span>
</a>
<a class="carousel-control-next right carousel-control" href="#myCarousel{{$item->id}}" role="button" data-slide="next">
        <span class="carousel-control-next-icon"></span>
</a>

  </div>
  @if($item->quantity <= 0)
  <p style="color:red;">Available Soon</p>
  @else
  <p><a href="{{route('item.show',['id' => $item->id])}}">{{$item->name}}</a></p>
  @endif
  <b >{{$item->price}}</b> <p class="EGP">EGP</p><br>
  
      @auth
        @if(Auth::user()->type == 1)
        <b>Quantity : {{$item->quantity}}</b><br>
        <div class="btn-group btn-group-sm" role="group">

        <a href="{{route('item.delete',['id' => $item->id])}}" onclick="return confirm('Are you sure to delete {{$item->name}}?')">
        <button type="button" class="btn btn-default actions">
        <i class="fa fa-lg fa-trash actionIcons"></i></button></a>
        <a href="{{route('item.edit',['id' => $item->id])}}">
        <button type="button" class="btn btn-default actions" ><i class="fa fa-pencil actionIcons"></i></button></a>
       
      
        <a href="{{route('hideitem',['id' => $item->id])}}">
        <button type="button" class="btn btn-default actions" >
        @if($item->hide == 1)<i class="fa fa-eye actionIcons" ></i>@else <i class="fa fa-eye-slash actionIcons" ></i> @endif</button></a>
         <a>  <button type="button" data-value="{{$item->id}}" class=" btn-addToFavorite btn btn-default actions" >
           <i class="fa fa-heart actionIcons" style="margin-left:-7px;"></i></button></a>
</div>
        


        @else
       
        <button 
        @if($item->quantity <= 0)
        disabled
        @endif type="button" class="btn btn-default btn-addtocart column1" data-value="{{$item->id}}" style="margin-bottom:10px;" style="color:black;" >
        Add to cart</button>
        <button type="button" data-value="{{$item->id}}" class=" btn-addToFavorite btn btn-default column text-center" >
           <i class="fa fa-heart"></i></button>
        @endif
        @else
        <button  @if($item->quantity <= 0)
        disabled
        @endif
         type="button" class="btn btn-default btn-addtocart column1 text-center" data-value="{{$item->id}}" style="margin-bottom:10px;" style="color:black;" >
         Add to cart</button>
         <button type="button" data-value="{{$item->id}}" class=" btn-addToFavorite btn btn-default column" >
           <i class="fa fa-heart"></i></button>
         @endauth

          


        <hr>
</div>

</div>

    @endforeach
    </section>

    </div>

</div>

<br>


<br>
<i class="fa fa-lg fa-spinner fa-spin" style="margin-left:50%"></i>
@include('errormessage')

{{--{!! $items->render() !!}--}}

<script type="text/javascript">


    $.ajaxSetup({

        headers: {

            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')

        }

    });
    var numberofitems=$("#countitems").val();
    if(numberofitems<10)
    {
       $('.fa-spinner').hide()
    }
  $(document).on("click", '.btn-addToFavorite', function(e) { 

  e.preventDefault();

      var id =  $(this).data('value');;
  $.ajax({

      type:'POST',

      url:"{{ route('addToFavorite') }}",

      data:{id:id},

      success:function(data){

        $('#messaga').text(data.message)
        $('#errormessage').modal(); 
          }

  });
  });
      
  $(document).on("click", '.btn-addtocart', function(e) { 

        e.preventDefault();

            var str =  $(this).data('value');;
          $.ajax({

            type:'POST',

            url:"{{ route('item.addToCart') }}",

            data:{name:str},

            success:function(data){

              if(data.message===undefined)
              {

                $(".countCart").text(data.countCart);
              }
              else
              {
                $('#messaga').text(data.message)
                // $('#errormessage').modal();
                $('#errormessage').modal('show');
                setTimeout(function() {
                    $('#errormessage').modal('hide');
                }, 1000);
              }
                
            }

          });
    });
  $(document).ready(function(){

      //fetch_customer_data();

      function fetch_customer_data(query = '')
      {
      $.ajax({
        url:"{{ route('ItemController.search') }}",
        method:'GET',
        data:{query:query},
        dataType:'json',
        success:function(data)
        {
      if(query != '')
      {
        $('.items').html(data.table_data);
        $('.fa-spinner').hide();

      }
      else
      {
        $('.fa-spinner').show();
        $('.items').html(data.table_data);
        
        $('.endless-pagination').data('next-page', data.next_page);
        $("#countitems").val(numberofitems+data.numberofitems);
        if(data.numberofitems<10)
    {
       $('.fa-spinner').hide()
    }
      }
     
        }
      })
      }

$(document).on('keyup', '#search', function(){
 var query = $(this).val();

 fetch_customer_data(query);
 
  
});
$(window).scroll(fetchitems);


function fetchitems() {


    var page = $('.endless-pagination').data('next-page');
    if(page !== null) {

        clearTimeout( $.data( this, "scrollCheck" ) );

        $.data( this, "scrollCheck", setTimeout(function() {
            var scroll_position_for_items_load = $(window).height() + $(window).scrollTop() + 100;

            if(scroll_position_for_items_load >= $(document).height()) {
                $.get(page, function(data){
                    
                    var numberofitems=$("#countitems").val();
                    
                    if(numberofitems<=10)
                    {

                      $('.items').html(data.items);
                      $('.endless-pagination').data('next-page', data.next_page);
                      $("#countitems").val(numberofitems+data.numberofitems);
                      
                    }
                    else{
                      $('.items').append(data.items);
                      $('.endless-pagination').data('next-page', data.next_page);
                    }
                    
                });
            }
        }, 350))

    }
    else{
      
      $('.fa-spinner').hide();
        }
}


});

</script>



@endsection
