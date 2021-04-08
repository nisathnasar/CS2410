@extends('layouts.app')
@section('content')
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-md-8 ">
                <div class="card overflow-hidden">
                    <div class="card-header">Adopted Animals - List of Adoptee and Adotpers</div>
                    <div class="card-body">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th></th>
                                    <th>Name</th>
                                    <th>Date of Birth</th>
                                    <th>Description</th>
                                    <th>Animal Type</th>
                                    <th>Adopter ID</th>
                                    <th>Adopter</th>
                                    <th colspan="1"></th>

                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($animals as $animal)
                                    <tr>
                                        <td colspan='1'>
                                            <img style="width:55px;height:55px" src="{{ asset('storage/images/' . $animal['image']) }}">
                                        </td>

                                        <td>{{ $animal['name'] }}</td>
                                        <td>{{ $animal['date_of_birth'] }}</td>
                                        <td>{{ $animal['description'] }}</td>
                                        <td>{{ $animal['animal_type'] }}</td>
                                        <td>{{ $animal['adopted_by']}}</td>
                                        <td>{{ App\Models\User::find($animal['adopted_by'])['name'] }}</td>
                                        <td><a href="{{ route('animals.show', ['animal' => $animal['id']]) }}" class="btn btnprimary">Details</a></td>

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
