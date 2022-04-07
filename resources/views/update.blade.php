@extends('layouts.master')
@section('title','Update Form')

@section('content')
<div class="container"  style="width:400px; margin-top:40px">
   <!-- to check if success update -->
   @if(Session::has('update-success'))
   <div class="p-2 alert alert-primary alert-dismissible fade show" role="alert">
      <span >{{Session::get('update-success')}}</span>
      <button type="button" class="p-2 m-1 btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
   </div>   
   <a href="{{route('users')}}" class="btn btn-outline-primary">Go Back</a>
   <!-- for sweet alert -->
   <script>
      swal({
         title: "Success!",
         text: "{{ Session::get('update-success') }}",
         icon: "success",
         button: "Ok",
      });
   </script>
   <!-- to check if error update -->
   @elseif(Session::has('update-fail'))
   <div class="p-2 alert alert-warning alert-dismissible fade show" role="alert">
      <span >{{Session::get('update-fail')}}</span>
      <button type="button" class="p-2 m-1 btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
   </div>
   <a href="{{route('users')}}" class="btn btn-outline-primary">Go Back</a> 
   <!-- for sweet alert -->
   <script>
      swal({
         title: "Update Fail!",
         text: "{{ Session::get('update-fail') }}",
         icon: "warning",
         button: "Ok",
      });
   </script>
   @endif



   <h3 class="text-primary">Update Form</h3>
   <form action="{{route('save.update')}}" method="POST" enctype="multipart/form-data" style="with:360px; margin-top:20px"class="p-2 border border-3">
      @csrf
      <div class="form-group mb-3">
         <input type="hidden" name="id" value="{{$data->id}}">
         <small for="name">Name:</small>
         <input name="name" type="text" class="form-control @error('name')in-valid @enderror" placeholder="Enter Name" value="{{$data->name}}" autocomplete="name"> 
         @error('name')
         <small class="text-danger">{{$message}}</small>
         @enderror        
      </div>
      <div class="form-group mb-3">
         <small for="email">Email address:</small>
         <input name="email" type="email" class="form-control @error('email')in-valid @enderror" placeholder="Enter Email" value="{{$data->email}}" autocomplete="email">
         @error('email')
         <small class="text-danger">{{$message}}</small>
         @enderror 
      </div>
      <div class="form-group mb-3">
         <small for="pass">New password:</small>
         <input name="pass" type="password" class="form-control @error('pass')in-valid @enderror" placeholder="Enter New password" autocomplete="re_pass">
         @error('pass')
         <small class="text-danger">{{$message}}</small>
         @enderror 
      </div>
      <div class="form-group mb-3">
         <small for="re_pass">Confirm new password:</small>
         <input name="re_pass" type="password" class="form-control @error('re_pass') in-valid @enderror" placeholder="Enter New Re-pass" autocomplete="re_pass">
         @error('re_pass')
         <small class="text-danger">{{$message}}</small>
         @enderror 
      </div>
      <div class="form-group mb-3">
         <small for="image">Choose Image</small>
         
         <input id="image" name="image" type="file" class="form-control @error('image') in-valid @enderror" placeholder="Choose Image" autocomplete="image">
         @error('image')
         <small class="text-danger">{{$message}}</small>
         @enderror 
         <div class="m-2 text-center border border-2">        
            <img style="width:100%;" id="preview" src="{{asset('public/images/'.$data->image)}}">
         </div>
      </div>
      <button type="submit" class="btn btn-primary">Submit</button>
   </form>
</div>
<script type="text/javascript">
      $('#image').change(function(evnet){
         $('#preview').attr('src',URL.createObjectURL(evnet.target.files[0]));
      });

      // one way also work ;)
      // $('#image').change(function(evnet){
      //    var reader = new FileReader();
      //    reader.onload = (e) => {
      //       $('#preview').attr('src', e.target.result);
      //    }
      //    reader.readAsDataURL(this.files[0]);
      // });
   
</script>
@endsection