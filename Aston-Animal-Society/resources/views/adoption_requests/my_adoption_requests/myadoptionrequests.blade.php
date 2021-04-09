@extends('layouts.app')
@section('content')
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-md-8 ">
                <div class="card overflow-hidden">
                    <div class="card-header">My Adoption Requests - List of all my adoption requests</div>
                    <div class="card-body">
                        <table class="table table-striped">
                            <thead>
                                <tr >
                                    <th></th>
                                    <th>Name</th>
                                    <th>Date of Birth</th>
                                    <th>Description</th>
                                    <th>Animal Type</th>
                                    <th>Request status</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($adoptionRequests as $adoptionRequest)
                                    <tr
                                    @if(App\Models\AdoptionRequest::find($adoptionRequest['id'])['request_status'] == 'approved')
                                    class="table-success"
                                    @elseif(App\Models\AdoptionRequest::find($adoptionRequest['id'])['request_status'] == 'denied')
                                    class="table-danger"
                                    @else
                                    class="table-default"
                                    @endif
                                    >
                                        <td colspan='1'>
                                            <img style="width:55px;height:55px" src="{{ asset('storage/images/' . App\Models\Animal::find($adoptionRequest['animal_id'])['image']) }}">
                                        </td>

                                        <td>{{ App\Models\Animal::find($adoptionRequest['animal_id'])['name'] }}</td>
                                        <td>{{ App\Models\Animal::find($adoptionRequest['animal_id'])['date_of_birth'] }}</td>
                                        <td>{{ App\Models\Animal::find($adoptionRequest['animal_id'])['description'] }}</td>
                                        <td>{{ App\Models\Animal::find($adoptionRequest['animal_id'])['animal_type'] }}</td>
                                        <td>{{ App\Models\AdoptionRequest::find($adoptionRequest['id'])['request_status'] }}</td>
                                        <td><a href="{{ route('animals.show', ['animal' => $adoptionRequest['id']]) }}"
                                            class="btn btnprimary">Details</a></td>

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
