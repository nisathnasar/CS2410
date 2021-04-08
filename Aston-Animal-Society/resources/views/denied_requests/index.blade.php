@extends('layouts.app')
@section('content')
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-md-8 ">
                <div class="card overflow-hidden">
                    <div class="card-header">Denied Requests - List of denied requests</div>
                    <div class="card-body">
                        <table class="table table-striped table-hover">
                            <thead>
                                <tr >
                                    <th></th>
                                    <th>Name</th>
                                    <th>Date of Birth</th>
                                    <th>Description</th>
                                    <th>Availability</th>
                                    <th>Requester ID</th>
                                    <th>Requester Name</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($userRequests as $userRequest)
                                    <tr>
                                        <td colspan='1'>
                                            <img style="width:55px;height:55px" src="{{ asset('storage/images/' . App\Models\Animal::find($userRequest['animal_id'])['image']) }}">
                                        </td>

                                        <td>{{ App\Models\Animal::find($userRequest['animal_id'])['name'] }}</td>
                                        <td>{{ App\Models\Animal::find($userRequest['animal_id'])['date_of_birth'] }}</td>
                                        <td>{{ App\Models\Animal::find($userRequest['animal_id'])['description'] }}</td>
                                        <td>{{ App\Models\Animal::find($userRequest['animal_id'])['availability'] }}</td>
                                        <td>{{ $userRequest['user_id']}}</td>
                                        <td>{{ App\Models\User::find($userRequest['user_id'])['name'] }}</td>
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
