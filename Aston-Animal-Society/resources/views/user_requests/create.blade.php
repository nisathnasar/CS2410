<!-- inherite master template app.blade.php -->
@extends('layouts.app')
<!-- define the content section -->
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10 ">
            <div class="card">
                <div class="card-header">Add a new animal</div>

                <!-- display the errors -->
                @if ($errors->any())
                <div class="alert alert-danger">
                    <ul> @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li> @endforeach
                    </ul>
                </div><br /> @endif
                <!-- display the success status -->

                @if (\Session::has('success'))
                <div class="alert alert-success">
                    <p>{{ \Session::get('success') }}</p>
                </div><br /> @endif

                <!-- define the form -->
                <div class="card-body">
                    @csrf
                    <form class="form-horizontal" method="POST"
                    action="{{url('user_requests') }}" enctype="multipart/form-data">
                        @csrf
                        <div class="col-md-6 col-md-offset-4">
                            <input name="id" type="hidden" value="{{$animals['id']}}">
                            <input type="submit" class="btn btn-primary" />
                            <input type="reset" class="btn btn-primary" />
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
