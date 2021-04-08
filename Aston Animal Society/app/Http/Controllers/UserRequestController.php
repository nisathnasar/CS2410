<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\UserRequest;

use App\Models\Animal;


use Illuminate\Support\Facades\Auth;

use Gate;


class UserRequestController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (!Gate::denies('add_animals')) {

            $userRequests = UserRequest::all();
            $userRequests = $userRequests->filter(
                function ($item) {
                    if ($item['request_status'] == 'waiting_for_approval') {
                        return $item;
                    }
                }
            )->toArray();
            return view('user_requests.index', compact('userRequests'));
        }
        else{
            return back();
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $user_id = Auth::id();
        $animal_id = $request->input('id');

        $modelExists = UserRequest::where('user_id', $user_id)->where('animal_id', $animal_id)->first() == null;
        $availableForAdoption = Animal::where('id', $animal_id)->where('availability', 'available')->first() != null;

        if ($modelExists && $availableForAdoption) {

            $userRequest = new UserRequest();
            $userRequest->user_id = $user_id;
            $userRequest->animal_id = $animal_id;
            $userRequest->request_status = 'waiting_for_approval';
            $userRequest->save();
            return redirect()->back()->with('requestsuccess', 'you have successfully made a request, please wait for approval');
        } else if (!$modelExists) {
            return redirect()->back()->with('modelexists', 'you have already made this request');
        } else if (!$availableForAdoption) {
            return redirect()->back()->with('availableforrequest', 'this animal is not available for request');
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, $id)
    {
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $user_request = UserRequest::where('user_id', $request->input('user_id'))->where('animal_id', $request->input('animal_id'))->get()->first();

        if ($user_request['request_status'] == 'waiting_for_approval') {
            $user_request->request_status = $request->input('request_status');
            $user_request->save();
        }

        if ($request->input('request_status') == 'approved') {
            $animal = Animal::where('id', $request->input('animal_id'))->get()->first();
            $animal->adopted_by = $request->input('user_id');
            $animal->availability = 'unavailable';
            $animal->save();
        }


        //if an animal has been adopted by 1 person, deny all other request to this animal.
        //get all requests to $request->input('animal_id')
        $user_requests = UserRequest::where('animal_id', $request->input('animal_id'))->get();
        //if user clicked approve and not deny
        if ($request->input('request_status') != 'denied') {
            //for each request, change status to denied.
            foreach ($user_requests as $user_request_unit) {
                if ($user_request_unit['request_status'] == 'waiting_for_approval') {
                    $user_request_unit->request_status = 'denied';
                    $user_request_unit->save();
                }
            }
        }

        $endingmsg = '.';

        if ($request->input('request_status') == 'approved') {
            $endingmsg = ' and denied adoption request to this animal for any other users(if any). Click "Adopted Animals" in menuto view approved requests.';
        }

        return redirect()->back()->with('approvemsg', 'Successfully '
                . $request->input('request_status')
                . ' adoption request for user id: '
                . $request->input('user_id')
                . ' with animal id: '
                . $request->input('animal_id')
                . $endingmsg);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
