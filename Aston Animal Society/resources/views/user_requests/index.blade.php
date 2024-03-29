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
                <div class="card-header">Adoption Requests - list of all adoption requests made by users</div>
                <div class="card-body ">
                    @csrf
                    <table class="table table-striped table-hover">
                        <thead>
                            <tr>
                                <td colspan="1"></td>
                                <th>Animal ID</th>
                                <th>Animal Name</th>
                                <th>Requester ID</th>
                                <th>Requester Name</th>
                                <th>Request status</th>
                                <th colspan="2" ></th>

                            </tr>
                        </thead>
                        <tbody>
                            @foreach($userRequests as $userRequest)
                            <tr>
                                <td colspan='1' >
                                    <img style="width:55px;height:55px" src="{{ asset('storage/images/'. App\Models\Animal::select('image')->where('id', $userRequest['animal_id'])->first()['image'] ) }}">
                                </td>

                                <td>{{$userRequest['animal_id']}}</td>

                                <td>{{App\Models\Animal::select('name')->where('id', $userRequest['animal_id'])->first()['name']}}</td>

                                <td>{{$userRequest['user_id']}}</td>

                                <td>{{App\Models\User::select('name')->where('id', $userRequest['user_id'])->first()['name']}}</td>

                                <td>{{$userRequest['request_status']}}</td>

                                <td>
                                    <form action="{{
                                    action(
                                        [App\Http\Controllers\UserRequestController::class, 'update'],
                                        ['user_request' => $userRequest['request_status']]
                                        )
                                    }}" method="post">
                                    @csrf
                                        <input name="request_status" type="hidden" value="{{'approved'}}">
                                        <input name="animal_id" type="hidden" value="{{$userRequest['animal_id']}}">
                                        <input name="user_id" type="hidden" value="{{$userRequest['user_id']}}">
                                        <input name="_method" type="hidden" value="PATCH">
                                        <button class="btn btn-primary" type="submit" >Approve</button>

                                    </form>

                                </td>
                                <td>
                                    @if (App\Models\UserRequest::where('animal_id', $userRequest['animal_id'])
                                    ->where('user_id', $userRequest['user_id'])->first()['request_status'] != 'denied'
                                        &&
                                        App\Models\UserRequest::where('animal_id', $userRequest['animal_id'])
                                        ->where('user_id', $userRequest['user_id'])->first()['request_status'] != 'approved'
                                        )

                                    <form action="{{
                                    action(
                                        [App\Http\Controllers\UserRequestController::class, 'update'],
                                        ['user_request' => $userRequest['request_status']]
                                        )
                                    }}" method="post">

                                    @csrf
                                        <input name="request_status" type="hidden" value="{{'denied'}}">
                                        <input name="animal_id" type="hidden" value="{{$userRequest['animal_id']}}">
                                        <input name="user_id" type="hidden" value="{{$userRequest['user_id']}}">
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
