@extends('layouts.app')
@section('content')
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-md-8 ">
                <div class="card overflow-hidden">
                    <div class="card-header">My Adoption Requests - List of all my adoption requests</div>
                    <div class="card-body">






                        <div class="container">
                            <div class="row justify-content-end">
                                <form action="{{ action([App\Http\Controllers\AdoptionRequestController::class, 'sortAndFilterMyAdoptionRequests']) }}">
                                    @csrf
                                    <label for="sort_by">Sort by</label>
                                    <select name="sort_by" id="">

                                        <option value="animal_name" @if ($sortingDetails['sort_by'] == 'animal_name') selected @endif>
                                            Animal Name
                                        </option>
                                        <option value="animal_id" @if ($sortingDetails['sort_by'] == 'animal_id') selected @endif>
                                            Animal ID
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
                                    <label for="request_status">Filters</label>

                                    <select name="request_status" id="">
                                        <option value="all" @if ($sortingDetails['request_status'] == 'all') selected @endif>
                                            All
                                        </option>
                                        <option value="waiting_for_approval" @if ($sortingDetails['request_status'] == 'waiting_for_approval') selected @endif>
                                            Pending
                                        </option>
                                        <option value="approved" @if ($sortingDetails['request_status'] == 'approved') selected @endif>
                                            Approved
                                        </option>
                                        <option value="denied" @if ($sortingDetails['request_status'] == 'denied') selected @endif>
                                            Denied
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
                                <tr >
                                    <th></th>
                                    <th>Animal ID</th>
                                    <th>Name</th>
                                    <th>Date of Birth</th>
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
                                            <img style="width:55px;height:55px"
                                                @if (App\Models\Animal::select('image')->where('id', $adoptionRequest['animal_id'])->first()['image'] != 'noimage.jpg')
                                                    src="{{ asset('storage/images/' . App\Models\Animal::select('image')->where('id', $adoptionRequest['animal_id'])->first()['image']) }}"
                                                @elseif (App\Models\Animal::select('image2')->where('id', $adoptionRequest['animal_id'])->first()['image2'] != 'noimage.jpg')
                                                    src="{{ asset('storage/images/' . App\Models\Animal::select('image2')->where('id', $adoptionRequest['animal_id'])->first()['image2']) }}"
                                                @else
                                                    src="{{ asset('storage/images/' . App\Models\Animal::select('image3')->where('id', $adoptionRequest['animal_id'])->first()['image3']) }}"
                                                @endif >

                                        </td>
                                        <td class="align-middle text-center">{{ $adoptionRequest['animal_id'] }}</td>
                                        <td class="align-middle">{{ App\Models\Animal::find($adoptionRequest['animal_id'])['name'] }}</td>
                                        <td class="align-middle">{{ App\Models\Animal::find($adoptionRequest['animal_id'])['date_of_birth'] }}</td>
                                        <td class="align-middle">{{ App\Models\Animal::find($adoptionRequest['animal_id'])['animal_type'] }}</td>

                                        <td class="align-middle">
                                            <strong>
                                                @if($adoptionRequest['request_status'] == 'approved')
                                                    APPROVED
                                                @elseif($adoptionRequest['request_status'] == 'waiting_for_approval')
                                                    DECISION PENDING
                                                @elseif($adoptionRequest['request_status'] == 'denied')
                                                    DENIED
                                                @endif
                                            </strong>
                                        </td>

                                        <td class="align-middle"><a class="btn btn-secondary" href="{{ route('animals.show', ['animal' => $adoptionRequest['id']]) }}"
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
