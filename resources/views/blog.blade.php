@extends('bar')

@section('content')
<link rel="stylesheet" href="/css/blog.css">
<div class="page">
<div class="container">
	<div class="row">
	      <form method="post" action="#" id="#">            
              <div class="form-group files">
                <label>Upload image or video </label>
                <input type="file" class="form-control" multiple="">
              </div>  
              <div class="form-group">
                <label for="post">Post :</label>
                <textarea class="form-control" id="post"></textarea>
            </div>
            <button type="submit" class="btn btn-primary pull-right">POST</button>
          </form>    
	  </div>
</div>
<hr>
<!-- <div class="embed-responsive embed-responsive-16by9">
  <iframe class="embed-responsive-item" src="https://www.youtube.com/embed/zpOULjyy-n8?rel=0" allowfullscreen></iframe>
</div> -->

<div class="panel panel-default">
  <div class="panel-body">Panel Content</div>
  <div class="panel-footer">Panel Footer</div>
</div>
</div>
<script>
$('.file-upload').file_upload();
</script>

@endsection