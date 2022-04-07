@extends('layouts.master')
@section('title','Register Form')

@section('content')
<div class="container"  style="width:400px; margin-top:40px">
   <!-- to check if success register -->
   @if(Session::has('success'))
   <div class="p-2 m-1 alert alert-success alert-dismissible fade show" role="alert">
      <span >{{Session::get('success')}}</span>
      <button type="button" class="p-2 m-1 btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
   </div>
   <script>
      swal({
         title: "Success!",
         text: "{{ Session::get('success') }}",
         icon: "success",
         button: "Ok",
      });
   </script>  
   <!-- to check if error register -->
   @elseif(Session::has('fail'))
   <div class="p-2 m-1 alert alert-warning alert-dismissible fade show" role="alert">
      <span >{{Session::get('fail')}}</span>
      <button type="button" class="p-2 m-1 btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
   </div> 
   <!-- for sweet alert -->
   <script>
      swal({
         title: "Register Fail!",
         text: "{{ Session::get('fail') }}",
         icon: "warning",
         button: "Ok",
      });
   </script>
   @endif



   <h3 class="text-primary">Register Form</h3>
   <form action="/user-register" method="POST" enctype="multipart/form-data" style="with:360px; margin-top:20px"class="p-2 border border-3">
      @csrf
      <div class="form-group mb-3">
         <small for="name">Name:</small>
         <input name="name" type="text" class="form-control @error('name') in-valid @enderror" placeholder="Enter Name" value="{{old('name')}}"> 
         @error('name')
         <small class="text-danger">{{$message}}</small>
         @enderror        
      </div>
      <div class="form-group mb-3">
         <small for="email">Email address:</small>
         <input name="email" type="email" class="form-control @error('email') in-valid @enderror" placeholder="Enter Email" value="{{old('email')}}">
         @error('email')
         <small class="text-danger">{{$message}}</small>
         @enderror 
      </div>
      <div class="form-group mb-3">
         <small for="pass">Password:</small>
         <input name="pass" type="password" class="form-control @error('pass') in-valid @enderror" placeholder="Enter password" autocomplete>   
         @error('pass')
         <small class="text-danger">{{$message}}</small>
         @enderror      
      </div>
      <div class="form-group mb-3">
         <small for="re_pass">Confirm Password:</small>
         <input  name="re_pass" type="password" class="form-control @error('re_pass') in-valid @enderror" placeholder="Enter re-password" autocomplete>
         @error('re_pass')
         <small class="text-danger">{{$message}}</small>
         @enderror 
      </div>
      <div class="form-group mb-3">
         <small for="image">Choose Image</small>
         <img class="mt-2 mb-2" src="" id="preview" width="100%" />
         <input id="image"  name="image" type="file" class="form-control @error('image') in-valid @enderror" placeholder="Choose Image">
         @error('image')
         <small class="text-danger">{{$message}}</small>
         @enderror 
      </div>
      <button  type="submit" class="btn btn-primary">Submit</button>
   </form>
</div>
<!-- how to preview image before upload -->
<script type="text/javascript">
   $(document).ready(function (e) {
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
   });
</script>
@endsection