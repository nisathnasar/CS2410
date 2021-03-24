@extends('layouts.app')
@section('content')
<div class="container">
   <div class="row justify-content-center">
      <div class="col-md-8 ">
         <div class="card">
            <div class="card-header">Display all vehicles</div>
            <div class="card-body">
               <table class="table table-striped" border="1" >
               <tr> <td> <b>Register Number </th> <td> {{$vehicle['reg_no']}}</td></tr>
               <tr> <th>Vehicle type </th> <td>{{$vehicle->category}}</td></tr>
               <tr> <th>Vehicle brand </th> <td>{{$vehicle->brand}}</td></tr>
               <tr> <td>Daily rate </th> <td>{{$vehicle->daily_rate}}</td></tr>
               <tr> <th>Notes </th> <td style="max-width:150px;" >{{$vehicle->description}}</td></tr>
               <tr> <td colspan='2' ><img style="width:100%;height:100%"
               src="{{ asset('storage/images/'.$vehicle->image)}}"></td></tr>
               </table>
               <table>
                  <tr>
                  <td><a href="{{route('vehicles.index')}}" class="btn btn-primary" role="button">Back to the
                  list</a></td>
                  <td><a href="{{ route('vehicles.edit', ['vehicle' => $vehicle['id']]) }}" class="btn btnwarning">Edit</a></td>
                  <td><form action="{{ route('vehicles.destroy', ['vehicle' => $vehicle['id']]) }}"
                  method="post"> @csrf
                  <input name="_method" type="hidden" value="DELETE">
                  <button class="btn btn-danger" type="submit">Delete</button>
                  </form></td>
                  </tr>
               </table>
            </div>
         </div>
      </div>
   </div>
</div>
@endsection