@extends('layouts.app')
@section('content')
<div class="container">
   <div class="row justify-content-center">
      <div class="col-md-8">
         <div class="card">
            <div class="card-header">Display all vehicles</div>
            <div class="card-body">
               <table class="table table-striped">
                  <thead>
                     <tr>
                        <th>Reg_NO</th>
                        <th>category</th>
                        <th>Brand</th>
                        <th>Daily_Rate</th>
                        <th colspan="3">Action</th>
                     </tr>

                     
                  </thead>
                  <tbody>
                     @foreach($vehicles as $vehicle)
                     <tr>
                        <td>{{$vehicle['reg_no']}}</td>
                        <td>{{$vehicle['category']}}</td>
                        <td>{{$vehicle['brand']}}</td>
                        <td>{{$vehicle['daily_rate']}}</td>

                        <td><a href="{{route('vehicles.show', ['vehicle' => $vehicle['id'] ] )}}" class="btn btnprimary">Details</a></td>
                        <td><a href="{{ route('vehicles.edit', ['vehicle' => $vehicle['id']]) }}" class="btn btnwarning">Edit</a></td>
                        <td>
                           <form action="{{ action([App\Http\Controllers\VehicleController::class, 'destroy'],
                           ['vehicle' => $vehicle['id']]) }}" method="post">
                              @csrf
                              <input name="_method" type="hidden" value="DELETE">
                              <button class="btn btn-danger" type="submit"> Delete</button>
                           </form>
                        </td>
                     </tr>
                     @endforeach
                  </tbody>
               </table>
            </div>
         </div>
      </div>
   </div>
</div>
@endsection