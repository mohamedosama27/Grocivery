@extends('bar')

@section('content')
@php
$totalprice=0
@endphp
@if(Session::get('number_of_items')!=0)
<link href="css/cart.css" rel="stylesheet" type="text/css" media="all" />



 
    @foreach($items as $selecteditem)
    <div class="row">
        
          <img class="col-xs-12 col-md-4" src="images\{{$selecteditem->item->images->first()->name}}" height="150" width="110">
          <a href="{{route('item.show',['id' => $selecteditem->item->id])}}">
            <p class="col-xs-12 col-md-3 text-center">{{$selecteditem->item->name}}</p>
         </a>
          <span class="col-xs-5 col-md-2">Price: {{$selecteditem->item->price}} <p class="EGP">EGP</p></span>
          <div class="col-xs-3 col-md-2 quantityDiv">

            <button type="button" class="btn-increment " data-value="{{$selecteditem->item->id}}"
                 >
            <i class="fa fa-plus-square"></i></button>


            <p id="quantity{{$selecteditem->item->id}}" class="inline">{{$selecteditem->Quantity}}</p>


            <button type="button" class="btn-decrement" data-value="{{$selecteditem->item->id}}"
                >
            <i class="fa fa-minus-square"></i>
            </button>

        </div>
        <a href="{{route('removefromcart',['id' => $selecteditem->item->id])}}" 
            class="col-xs-3 col-md-1 btn-danger">
            Remove
        </a>
        <div class="col-xs-7 col-md-2 pull-right">
            <b>Total price : </b>
            <div class="inline"
            id="totalprice{{$selecteditem->item->id}}">
                {{$selecteditem->item->price*$selecteditem->Quantity}}</div>
            
            <p class="EGP">EGP</p>
        </div>
       
    </div>
    @php $totalprice+=$selecteditem->item->price*$selecteditem->Quantity @endphp

    @endforeach
    <hr>
<div class="col-xs-8 pull-right">
    <div class="price invoice">
      <label>Subtotal : </label>
      <div class=" inline" id="cart-subtotal">{{$totalprice}}</div>
    </div>
    <div class="price invoice">
      <label>Shipping : </label>
      <div class="totals-value inline" id="cart-tax">10</div>
    </div>
   
    <div class="price invoice">
      <label>Total Price : </label>
      <div class="inline" id="cart-total">{{$totalprice+10}}</div>
    </div>
    @include('errormessage')
  @include('addaddress')
    <a  @auth data-toggle="modal" data-target="#addaddress" @else href=" login" @endauth >
  <button class="checkoutButton btn">Checkout</button>
</div>
</div>
@else

<h1 style="margin-top:10%;font-size:26px;" class="battalion text-center" >Your cart is empty</h1>

@endif

<script type="text/javascript">

   

    $.ajaxSetup({

        headers: {

            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')

        }

    });
    $(document).on("click", '.btn-decrement', function(e) { 

        e.preventDefault();

            var id =  $(this).data('value');
        $.ajax({

            type:'POST',

            url:"{{ route('decrementItem') }}",

            data:{id:id},
            datatype:'json',

            success:function(data){
              $("#cart-subtotal").text(data.totalprice);
              $("#cart-total").text(data.totalprice+10);
              $("#quantity"+id).text(data.quantity); 
              $("#totalprice"+id).text(data.item_total_price)             
              $("#countcart").text(data.countCart);
              

       
            }

        });

});
    $(document).on("click", '.btn-increment', function(e) { 


  

       e.preventDefault();

           var id =  $(this).data('value');
        $.ajax({

           type:'POST',

           url:"{{ route('incrementItem') }}",

           data:{id:id},
           datatype:'json',

           success:function(data){

            if(data.message===undefined){

              $("#quantity"+id).text(data.quantity);
              $("#cart-total").text(data.totalprice+10);    
              $("#totalprice"+id).text(data.item_total_price);   
              $("#countcart").text(data.countCart);
              $("#cart-subtotal").text(data.totalprice);

            }
            else
            {
              $('#messaga').text(data.message)
              $('#errormessage').modal();
            }

    
           }

        });

	});

 

</script>
@endsection