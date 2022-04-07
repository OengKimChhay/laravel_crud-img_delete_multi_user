@extends('layouts.master')
@section('title','Users')

@section('content')
   <!-- to check if success register -->
   @if(Session::has('delete-success'))
   <div class="p-2 m-5 alert alert-danger alert-dismissible fade show" role="alert">
      <span >{{Session::get('delete-success')}}</span>
      <button type="button" class="p-2 m-1 btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
   </div>   
   <!-- to check if error register -->
   @elseif(Session::has('delete-fail'))
   <div class="p-2 m-5 alert alert-warning alert-dismissible fade show" role="alert">
      <span >{{Session::get('delete-fail')}}</span>
      <button type="button" class="p-2 m-1 btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
   </div> 
   @endif


<div class="container mt-5">
   <table class="table table-bordered">
   <thead>
      <tr>
         <th scope="col">
            Checked<input type="checkbox" name="checkAll" id="checkAll" class="ml-1">
            <a href="#" id="delet_all" class="ml-2 btn btn-outline-danger">Delete All</a>
         </th>
         <th scope="col">#ID</th>
         <th scope="col">Nmae</th>
         <th scope="col">Email</th>
         <th scope="col">Image</th>
         <th scope="col">Date</th>
         <th scope="col" class="text-center">Action</th>
      </tr>
   </thead>
   <tbody>
   @foreach($data as $item)
      <tr>
         <td class="text-center"><input type="checkbox" name="allids" class='checkbox' value="{{$item->id}}"></td>
         <td style="width:20px">{{$item->id}}</td>
         <td>{{$item->name}}</td>
         <td>{{$item->email}}</td>
         <td class="text-center">
            <img style="height:60px;" src="{{asset('public/images/'.$item->image)}}">
         </td>
         <td>{{date('F d, Y', strtotime($item->created_at->setTimezone('Asia/Phnom_Penh')))}} at {{date('g:i A ', strtotime($item->created_at->setTimezone('Asia/Phnom_Penh')))}}<br> {{$item->created_at->diffForHumans()}}</td>
         <td class="text-center">
            <a class="btn btn-primary" href="/user-update/{{$item->id}}">Update</a>
            <a class="btn btn-danger" href="/user-delete/{{$item->id}}">Delete</a>
         </td>
      </tr>
   @endforeach
   </tbody>
   </table>
   <small>{{$data->links()}}</small>
</div>
<script>
$(function(){
   $('#checkAll').click(function(){    
      $('.checkbox').prop('checked',this.checked);    
   });

   $("#delet_all").on('click',function(e){
      e.prventDefault;
      var All_id = [];
      $("input:checkbox[name=allids]:checked").each(function(){ //or $(".checkbox:checked")...
         All_id.push($(this).val());
      }); 

      if(All_id.length <=0){ //prevent user doesn't checkbox
         alert("Please select row.");
      }else{
         if(confirm("Are you sure you want to delete this row?"))
         $.ajax({
            url: "{{route('deleteAll')}}",
            type: "DELETE",
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
            data: {
               _token: $('meta[name="csrf-token"]').attr('content'),
               ids: All_id
            },
            success: function(response){
               alert(response);
               location.reload();
            },
            error: function(e){
               alert(e.responseText);
            }
         });
      }
   });



});
</script>

@endsection