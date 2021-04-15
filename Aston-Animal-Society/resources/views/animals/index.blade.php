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
                <div class="card overflow-auto">
                    <div class="card-header">Animals - list of animals</div>
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
                                        <option value="id" @if ($sortingDetails['sort_by'] == 'id') selected @endif>
                                            Animal ID
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
                                    <label for="sort_by">Filters</label>
                                    <select name="availability" id="">
                                        <option value="all" @if ($sortingDetails['availability'] == 'all') selected @endif>
                                            All
                                        </option>
                                        <option value="available" @if ($sortingDetails['availability'] == 'available') selected @endif>
                                            Available
                                        </option>
                                        <option value="unavailable" @if ($sortingDetails['availability'] == 'unavailable') selected @endif>
                                            Unavailable
                                        </option>
                                    </select>

                                    <select name="animal_type" id="">
                                        <option value="all" @if ($sortingDetails['animal_type'] == 'all') selected @endif>
                                            All
                                        </option>
                                        <option value="cat" @if ($sortingDetails['animal_type'] == 'cat') selected @endif>
                                            cats
                                        </option>
                                        <option value="dog" @if ($sortingDetails['animal_type'] == 'dog') selected @endif>
                                            dogs
                                        </option>
                                        <option value="bird" @if ($sortingDetails['animal_type'] == 'bird') selected @endif>
                                            birds
                                        </option>
                                        <option value="fish" @if ($sortingDetails['animal_type'] == 'fish') selected @endif>
                                            fishes
                                        </option>
                                        <option value="reptile" @if ($sortingDetails['animal_type'] == 'reptile') selected @endif>
                                            reptiles
                                        </option>
                                        <option value="horse" @if ($sortingDetails['animal_type'] == 'horse') selected @endif>
                                            horses
                                        </option>
                                        <option value="other" @if ($sortingDetails['animal_type'] == 'other') selected @endif>
                                            other animals
                                        </option>
                                    </select>
                                    <button class="btn btn-info" type="submit">Apply</button>
                                </form>
                            </div>
                        </div>



                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th></th>
                                    <th>Animal ID</th>
                                    <th>Name</th>
                                    <th>Date of Birth</th>
                                    {{-- <th>Description</th> --}}
                                    <th>Animal Type</th>
                                    <th>Availability</th>
                                    <th colspan="3"></th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($animals as $animal)
                                    <tr

                                    @if(App\Models\AdoptionRequest::select('request_status')->where('user_id', Auth::id())->where('animal_id', $animal['id'])->exists())
                                        @if(App\Models\AdoptionRequest::select('request_status')->where('user_id', Auth::id())->where('animal_id', $animal['id'])->first()['request_status'] == 'approved')
                                            class="table-success"
                                        @elseif(App\Models\AdoptionRequest::select('request_status')->where('user_id', Auth::id())->where('animal_id', $animal['id'])->first()['request_status'] == 'denied')
                                            class="table-danger"
                                        @endif
                                    @endif >

                                        <td colspan='1'>
                                            <img style="width:55px;height:55px" class="img-fluid"
                                                @if ($animal['image'] != 'noimage.jpg')
                                                    src="{{ asset('storage/images/' . $animal['image']) }}"
                                                @elseif ($animal['image2'] != 'noimage.jpg')
                                                    src="{{ asset('storage/images/' . $animal['image2']) }}"
                                                @else
                                                    src="{{ asset('storage/images/' . $animal['image3']) }}"
                                                @endif >
                                        </td>

                                        <td class="align-middle text-center">{{ $animal['id'] }}</td>
                                        <td class="align-middle">{{ $animal['name'] }}</td>
                                        <td class="align-middle">{{ $animal['date_of_birth'] }}</td>
                                        {{-- <td class="align-middle">{{ $animal['description'] }}</td> --}}
                                        <td class="align-middle">{{ $animal['animal_type'] }}</td>
                                        <td class="align-middle">{{ $animal['availability'] }}</td>

                                        <td class="align-middle"><a href="{{ route('animals.show', ['animal' => $animal['id']]) }}"
                                                class="btn btn-secondary">Details</a></td>

                                        @if (!Gate::denies('add_animals'))

                                            <td class="align-middle"><a href="{{ route('animals.edit', ['animal' => $animal['id']]) }}"
                                                    class="btn btn-secondary">Edit</a></td>

                                            <td class="align-middle">
                                                <form
                                                    action="{{ action([App\Http\Controllers\AnimalController::class, 'destroy'], ['animal' => $animal['id']]) }}"
                                                    method="post">
                                                    @csrf
                                                    <input name="_method" type="hidden" value="DELETE">
                                                    <button class="btn btn-danger" type="submit"> Delete</button>
                                                </form>
                                            </td>

                                        @else

                                            <td class="align-middle">
                                                <form
                                                    action="{{ action([App\Http\Controllers\AdoptionRequestController::class, 'create']) }}"
                                                    method="put">
                                                    @csrf
                                                    <input name="id" type="hidden" value="{{ $animal['id'] }}">

                                                    @if (App\Models\AdoptionRequest::where('user_id', Auth::id())->where('animal_id', $animal['id'])->first() == null &&
                                                        App\Models\Animal::where('id', $animal['id'])->where('availability', 'available')->first() != null)

                                                        <button class="btn btn-primary" type="submit"
                                                            style="white-space: nowrap">Request for adoption</button>

                                                    @elseif(App\Models\AdoptionRequest::where('user_id', Auth::id())->
                                                        where('animal_id', $animal['id'])->first() != null)

                                                        {{-- if this record already exists, then print the status --}}
                                                        <strong>

                                                        {{-- {{ App\Models\AdoptionRequest::select('request_status')->where('user_id', Auth::id())->where('animal_id', $animal['id'])->first()['request_status'] }} --}}
                                                        @if(App\Models\AdoptionRequest::select('request_status')->where('user_id', Auth::id())->where('animal_id', $animal['id'])->first()['request_status'] == 'approved')
                                                            ADOPTED
                                                        @elseif(App\Models\AdoptionRequest::select('request_status')->where('user_id', Auth::id())->where('animal_id', $animal['id'])->first()['request_status'] == 'waiting_for_approval')
                                                            DECISION PENDING
                                                        @elseif(App\Models\AdoptionRequest::select('request_status')->where('user_id', Auth::id())->where('animal_id', $animal['id'])->first()['request_status'] == 'denied')
                                                            DENIED
                                                        @endif
                                                        </strong>
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
