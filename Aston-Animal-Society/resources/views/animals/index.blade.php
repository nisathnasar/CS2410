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
                        <div class="container">
                            <div class="row justify-content-end">
                                <form action="{{ action([App\Http\Controllers\AnimalController::class, 'sortBy']) }}">
                                    @csrf
                                    <label for="sort_by">Sort by</label>
                                    <select name="sort_by" id="">
                                        <option value="name" @if ($sortingDetails['sort_by'] == 'name') selected @endif>
                                            Name
                                        </option>
                                        <option value="date_of_birth" @if ($sortingDetails['sort_by'] == 'date_of_birth') selected @endif>
                                            Date of Birth
                                        </option>
                                    </select>
                                    <select name="sorting_order" id="">
                                        <option value="asc" @if ($sortingDetails['sorting_order'] == 'asc') selected @endif>
                                            Ascending
                                        </option>
                                        <option value="desc" @if ($sortingDetails['sorting_order'] == 'desc') selected @endif>
                                            Descending
                                        </option>
                                    </select>
                                    <button class="btn btn-info" type="submit">Sort</button>
                                </form>
                            </div>
                        </div>
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th></th>
                                    <th>Name</th>
                                    <th>Date of Birth</th>
                                    <th>Description</th>
                                    <th>Animal Type</th>
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
                                        <td>{{ $animal['animal_type'] }}</td>
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
                                                    @csrf
                                                    <input name="id" type="hidden" value="{{ $animal['id'] }}">

                                                    @if (App\Models\UserRequest::where('user_id', Auth::id())->where('animal_id', $animal['id'])->first() == null &&
                                                        App\Models\Animal::where('id', $animal['id'])->where('availability', 'available')->first() != null)

                                                        <button class="btn btn-primary" type="submit"
                                                            style="white-space: nowrap">Request for adoption</button>

                                                    @elseif(App\Models\UserRequest::where('user_id', Auth::id())->
                                                        where('animal_id', $animal['id'])->first() != null)

                                                        {{-- if this record already exists, then print the status --}}
                                                        {{ App\Models\UserRequest::select('request_status')->where('user_id', Auth::id())->where('animal_id', $animal['id'])->first()['request_status'] }}

                                                    @endif

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
