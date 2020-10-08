
@extends('bar')

@section('content')
 
<meta http-equiv="X-UA-Compatible" content="IE=edge">

<meta name="csrf-token" content="{{ csrf_token() }}" />
<link rel="stylesheet" href="/css/show_item.css">

	<div class="container">
		<div class="card">
			<div class="container-fliud">
				<div class="wrapper row">
					<div class="preview col-md-6">
						
						<div class="preview-pic tab-content">
          @foreach($item->images as $image)
             @if ($loop->first)
						  <div class="tab-pane active" id="pic-{{$loop->iteration}}"><img src={{ URL::asset("images/{$image->name}")}} alt="{{$image->name}}" /></div>
						  @else
              <div class="tab-pane" id="pic-{{$loop->iteration}}"><img max-height="200" max-width="200" src={{ URL::asset("images/{$image->name}")}} alt="{{$image->name}}" /></div>
              @endif
          @endforeach
            </div>
						<ul class="preview-thumbnail nav nav-tabs">
            @foreach($item->images as $image)
             @if ($loop->first)
             
						  <li class="active"><a data-target="#pic-{{$loop->iteration}}" data-toggle="tab"><img src={{ URL::asset("images/{$image->name}")}} /></a></li>
						  @else
              <li><a data-target="#pic-{{$loop->iteration}}" data-toggle="tab"><img src={{ URL::asset("images/{$image->name}")}} /></a></li>
              @endif
          @endforeach
            </ul>
						
					</div>
					<div class="details col-md-6">
						<h3 class="product-title">{{$item->name}}</h3>
						
						<p class="product-description">{{$item->description}}</p>
						<h4 class="price"><span>{{$item->price}} <p class="EGP">LE</p></span></h4>
					
				
						<div class="action">
        @if(Auth::check() && Auth::user()->type == 1)

        <p><b>Quantity : </b>{{$item->quantity}}</p>

        <a href="{{route('item.delete',['id' => $item->id])}}" onclick="return confirm('Are you sure to delete {{$item->name}}?')"><button type="button" class=" btn btn-default" style="margin-bottom:10px;" style="color:black;"><b>Delete</b></button></a>
        
        <a href="{{route('item.edit',['id' => $item->id])}}">

        <button type="button" class=" btn btn-default" style="margin-bottom:10px;color:black;"><b>Edit</b></button></a>

        <a href="{{route('hideitem',['id' => $item->id])}}">

        <button type="button" class="btn btn-default" style="margin-bottom:10px;color:black;">
        
        <b>@if($item->hide == 1)un Hide @else Hide @endif</b></button></a>

        @else
        <button type="button" class="btn btn-default btn-addtocart" data-value="{{$item->id}}" style="margin-bottom:10px;" style="color:black;"><b>Add to Cart</b></button>
        
        @endif
       						
      	<button class=" btn btn-default btn-addToFavorite" data-value="{{$item->id}}" type="button" style="margin-bottom:10px;color:black;"><span class="fa fa-heart fa-fav"></span></button>
            </div>

					</div>
				</div>
      <!-- start Reviews section -->
      <br>
      
<div class="container">
    <div class="row">
        <div class="panel panel-default widget">
            <div class="panel-heading">
                <h3 class="panel-title">
                    Reviews</h3>
                
            </div>
            <div class="panel-body">
                <ul class="list-group">
                @foreach($item->reviews as $review)

                    <li class="list-group-item">
                        <div class="row">
                          
                            <div class="col-xs-10 col-md-11">
                                <div>
                                    <p>{{$review->review}}</p>
                                    <div class="mic-info">
                                        By: {{$review->user->name}} on {{$review->created_at->format('d-m-Y')}}
                                    </div>
                                </div>
                             
                                <div class="action">
                                   @auth
                                   @if(Auth::user()->type == 1)
                                    <button type="button" class="btn btn-success btn-xs" title="Approved">
                                    <i class="fa fa-check"></i>
                                    </button>
                                    @endif
                                    @if($review->user->id == Auth::user()->id || Auth::user()->type == 1)
                                    <a href="{{route('review.delete',['id' => $review->id])}}">
                                      <button type="button" class="btn btn-danger btn-xs" title="Delete">
                                      <i class="fa fa-trash"></i>
                                    </a>
                                    </button>
                                    @endif
                                    @endauth
                                </div>
                            </div>
                        </div>
                    </li>
                  @endforeach
                    <li class="list-group-item">
                        <div class="row">
                        <form method="POST" action="{{route('review.store')}}">
                          @csrf
                          @method('PUT')
                            <div class="form-group">
                              <h3>Add your review:</h3>
                              <input value="{{$item->id}}" name="id" hidden/>
                              <textarea class="form-control" name="review"></textarea>
                              <button type="submit" class="btn btn-primary pull-right">POST</button>
                            </div>
                          </form>
                        </div>
                   </li>
                </ul>
            </div>
        </div>
    </div>
</div>
<!-- end reviews section -->
			</div>
		</div>
  </div>
  @include('errormessage')

  <script type="text/javascript">

$.ajaxSetup({

    headers: {

        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')

    }

});

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
      $(".countfavorites").text(data.countFavorites);

         }

 });
});
$(document).on("click", '.btn-addtocart', function(e) { 

   e.preventDefault();

       var str =  $(this).data('value');
    $.ajax({

       type:'POST',

       url:"{{ route('item.addToCart') }}",
       data:{name:str},
       
       success:function(data){

        if(data.message===undefined)
            {

              $("#countcart").text(data.countCart);
              $('#messaga').text("Added Sucessfully")
                // $('#errormessage').modal();
                $('#errormessage').modal('show');
                setTimeout(function() {
                    $('#errormessage').modal('hide');
                }, 1000);
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
