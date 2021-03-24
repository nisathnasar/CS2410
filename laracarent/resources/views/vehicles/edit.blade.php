@extends('layouts.app')
@section('content')
<div class="container">
   <div class="row justify-content-center">
      <div class="col-md-8 ">
         <div class="card">
            <div class="card-header">Edit and update the vehicle</div>
            @if ($errors->any())
            <div class="alert alert-danger">
               <ul>
               @foreach ($errors->all() as $error)
               <li>{{ $error }}</li>
               @endforeach
               </ul>
            </div><br />
            @endif
            @if (\Session::has('success'))
            <div class="alert alert-success">
            <p>{{ \Session::get('success') }}</p>
            </div><br />
            @endif
            <div class="card-body">
            <form class="form-horizontal" method="POST" action="{{ route('vehicles.update', ['vehicle' =>
            $vehicle['id']]) }}" enctype="multipart/form-data" >
            @method('PATCH')
            @csrf
               <div class="col-md-8">
               <label >Vehicle Register Number</label>
               <input type="text" name="reg_no" value="{{$vehicle->reg_no}}"/>
               </div>
               <div class="col-md-8">
               <label>vehicle Type</label>
               <select name="category" value="{{ $vehicle->category }}">
               <option value="car">Car</option>
               <option value="truck">Truck</option>
               </select>
               </div>
               <div class="col-md-8">
               <label >Daily-rate</label>
               <input type="text" name="daily_rate" value="{{$vehicle->daily_rate}}" />
               </div>
               <div class="col-md-8">
               <label >Vehicle Brand</label>
               <input type="text" name="brand" value="{{$vehicle->brand}}" />
               </div>
               <div class="col-md-8">
               <label >Description</label>
               <textarea rows="4" cols="50" name="description" > {{$vehicle->description}}
               </textarea>
               </div>
               <div class="col-md-8">
               <label>Image</label>
               <input type="file" name="image" />
               </div>
               <div class="col-md-6 col-md-offset-4">
               <input type="submit" class="btn btn-primary" />
               <input type="reset" class="btn btn-primary" />
               </a>
               </div>
            </form>
            </div>
         </div>
      </div>
   </div>
</div>
@endsection