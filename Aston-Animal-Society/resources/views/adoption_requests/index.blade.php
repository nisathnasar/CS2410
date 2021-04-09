@extends('layouts.app')
@section('content')
<div class="container-fluid">
    @if (session()->has('approvemsg'))
        <div class="alert alert-success">
            {{ session()->get('approvemsg') }}
        </div>
    @endif
    <div class="row justify-content-center">
        <div class="col-md-8 ">
            <div class="card overflow-auto" >
                <div class="card-header">Adoption Requests - list of active adoption requests made by users</div>
                <div class="card-body ">
                    <div class="container">
                        <div class="row justify-content-end">
                            <form action="{{ action([App\Http\Controllers\AdoptionRequestController::class, 'sortBy']) }}">
                                @csrf
                                <label for="sort_by">Sort by</label>
                                <select name="sort_by" id="">
                                    <option value="animal_name" @if ($sortingDetails['sort_by'] == 'animal_name') selected @endif>
                                        Animal Name
                                    </option>
                                    <option value="requester_name" @if ($sortingDetails['sort_by'] == 'requester_name') selected @endif>
                                        Requester Name
                                    </option>
                                    <option value="animal_id" @if ($sortingDetails['sort_by'] == 'animal_id') selected @endif>
                                        Animal ID
                                    </option>
                                    <option value="requester_id" @if ($sortingDetails['sort_by'] == 'requester_id') selected @endif>
                                        Requester ID
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
                                        Waiting for Approval
                                    </option>
                                    <option value="approved" @if ($sortingDetails['request_status'] == 'approved') selected @endif>
                                        Approved
                                    </option>
                                    <option value="denied" @if ($sortingDetails['request_status'] == 'denied') selected @endif>
                                        Denied
                                    </option>
                                </select>

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
                                <button class="btn btn-info" type="submit">Search</button>
                            </form>
                        </div>
                    </div>


                    @csrf
                    <table class="table table-striped ">
                        <thead>
                            <tr>
                                <td colspan="1"></td>
                                <th>Animal ID</th>
                                <th>Animal Name</th>
                                <th>Animal Type</th>
                                <th>Requester ID</th>
                                <th>Requester Name</th>
                                <th>Request status</th>
                                <th colspan="2" ></th>

                            </tr>
                        </thead>
                        <tbody>
                            @foreach($adoptionRequests as $adoptionRequest)
                            <tr
                            @if(App\Models\AdoptionRequest::where('animal_id', $adoptionRequest['animal_id'])
                            ->where('user_id', $adoptionRequest['user_id'])->first()['request_status'] == 'approved')
                                class="table-success"
                            @elseif(App\Models\AdoptionRequest::where('animal_id', $adoptionRequest['animal_id'])
                            ->where('user_id', $adoptionRequest['user_id'])->first()['request_status'] == 'denied')
                                class="table-danger"
                            @else
                                class="table-default"
                            @endif
                            >
                                <td colspan='1' >
                                    <img style="width:55px;height:55px" src="{{ asset('storage/images/'. App\Models\Animal::select('image')->where('id', $adoptionRequest['animal_id'])->first()['image'] ) }}">
                                </td>

                                <td>{{$adoptionRequest['animal_id']}}</td>

                                <td>{{App\Models\Animal::select('name')->where('id', $adoptionRequest['animal_id'])->first()['name']}}</td>

                                <td>{{App\Models\Animal::select('animal_type')->where('id', $adoptionRequest['animal_id'])->first()['animal_type']}}</td>

                                <td>{{$adoptionRequest['user_id']}}</td>

                                <td>{{App\Models\User::select('name')->where('id', $adoptionRequest['user_id'])->first()['name']}}</td>

                                <td>{{$adoptionRequest['request_status']}}</td>

                                <td>
                                    @if (App\Models\AdoptionRequest::where('animal_id', $adoptionRequest['animal_id'])
                                    ->where('user_id', $adoptionRequest['user_id'])->first()['request_status'] != 'denied'
                                        &&
                                        App\Models\AdoptionRequest::where('animal_id', $adoptionRequest['animal_id'])
                                        ->where('user_id', $adoptionRequest['user_id'])->first()['request_status'] != 'approved'
                                        )

                                    <form action="{{
                                    action(
                                        [App\Http\Controllers\AdoptionRequestController::class, 'update'],
                                        ['adoption_request' => $adoptionRequest['request_status']]
                                        )
                                    }}" method="post">
                                    @csrf
                                        <input name="request_status" type="hidden" value="{{'approved'}}">
                                        <input name="animal_id" type="hidden" value="{{$adoptionRequest['animal_id']}}">
                                        <input name="user_id" type="hidden" value="{{$adoptionRequest['user_id']}}">
                                        <input name="_method" type="hidden" value="PATCH">
                                        <button class="btn btn-primary" type="submit" >Approve</button>

                                    </form>

                                    @endif

                                </td>
                                <td>
                                    @if (App\Models\AdoptionRequest::where('animal_id', $adoptionRequest['animal_id'])
                                    ->where('user_id', $adoptionRequest['user_id'])->first()['request_status'] != 'denied'
                                        &&
                                        App\Models\AdoptionRequest::where('animal_id', $adoptionRequest['animal_id'])
                                        ->where('user_id', $adoptionRequest['user_id'])->first()['request_status'] != 'approved'
                                        )

                                    <form action="{{
                                    action(
                                        [App\Http\Controllers\AdoptionRequestController::class, 'update'],
                                        ['adoption_request' => $adoptionRequest['request_status']]
                                        )
                                    }}" method="post">

                                    @csrf
                                        <input name="request_status" type="hidden" value="{{'denied'}}">
                                        <input name="animal_id" type="hidden" value="{{$adoptionRequest['animal_id']}}">
                                        <input name="user_id" type="hidden" value="{{$adoptionRequest['user_id']}}">
                                        <input name="_method" type="hidden" value="PATCH">
                                        <button class="btn btn-danger" type="submit">Deny</button>

                                    </form>

                                    @endif

                                </td>
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
