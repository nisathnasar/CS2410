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
                                    <th>Animal ID</th>
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

                                        <td class="align-middle text-center">{{ $animal['id'] }}</td>
                                        <td class="align-middle">{{ $animal['name'] }}</td>
                                        <td class="align-middle">{{ $animal['date_of_birth'] }}</td>
                                        <td class="align-middle">{{ $animal['description'] }}</td>
                                        <td class="align-middle">{{ $animal['animal_type'] }}</td>
                                        <td class="align-middle">{{ $animal['adopted_by']}}</td>
                                        <td class="align-middle">{{ App\Models\User::find($animal['adopted_by'])['name'] }}</td>
                                        <td class="align-middle"><a class="btn btn-secondary"href="{{ route('animals.show', ['animal' => $animal['id']]) }}" class="btn btnprimary">Details</a></td>

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
