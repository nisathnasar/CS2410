@extends('layouts.app')
@section('content')
    <div class="container-fluid">
        @if (session()->has('requestsuccess'))
            <div class="alert alert-success">
                {{ session()->get('requestsuccess') }}
            </div>
        @elseif (session()->has('modelexists'))
            <div class="alert alert-success">
                {{ session()->get('modelexists') }}
            </div>
        @elseif (session()->has('availableforrequest'))
            <div class="alert alert-success">
                {{ session()->get('availableforrequest') }}
            </div>
        @endif
        <div class="row justify-content-center">
            <div class="col-md-8 ">
                <div class="card overflow-hidden">
                    <div class="card-header">Animals - list of available animals</div>
                    <div class="card-body">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th></th>
                                    <th>Name</th>
                                    <th>Date of Birth</th>
                                    <th>Description</th>
                                    <th>Availability</th>
                                    <th colspan="3"></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($animals as $animal)
                                    <tr>
                                        <td colspan='1'>
                                            <img style="width:55px;height:55px"
                                                src="{{ asset('storage/images/' . $animal['image']) }}">
                                        </td>

                                        <td>{{ $animal['name'] }}</td>
                                        <td>{{ $animal['date_of_birth'] }}</td>
                                        <td>{{ $animal['description'] }}</td>
                                        <td>{{ $animal['availability'] }}</td>

                                        <td><a href="{{ route('animals.show', ['animal' => $animal['id']]) }}"
                                                class="btn btnprimary">Details</a></td>

                                        @if (!Gate::denies('add_animals'))

                                            <td><a href="{{ route('animals.edit', ['animal' => $animal['id']]) }}"
                                                    class="btn btnwarning">Edit</a></td>

                                            <td>
                                                <form
                                                    action="{{ action([App\Http\Controllers\AnimalController::class, 'destroy'], ['animal' => $animal['id']]) }}"
                                                    method="post">
                                                    @csrf
                                                    <input name="_method" type="hidden" value="DELETE">
                                                    <button class="btn btn-danger" type="submit"> Delete</button>
                                                </form>
                                            </td>

                                        @else

                                            <td>
                                                <form
                                                    action="{{ action([App\Http\Controllers\UserRequestController::class, 'create']) }}"
                                                    method="put">
                                                    <input name="id" type="hidden" value="{{ $animal['id'] }}">

                                                    <button class="btn btn-primary" type="submit"
                                                            style="white-space: nowrap">Request for adoption</button>
                                                </form>

                                            </td>

                                        @endif

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
