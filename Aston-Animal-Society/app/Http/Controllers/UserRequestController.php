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
        $userRequests = UserRequest::all()->toArray();
        return view('user_requests.index', compact('userRequests'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        //$accountsQuery = Animal::all();

        //$this->store($request);

        //return view('user_requests.create', array('animals'=>$accountsQuery));

        //return view('animals.index');

        //return \App::call('App\Http\Controllers\AnimalController@index');

        //return redirect()->back()->withSuccess('you have successfully made a request, please wait for approval');

        //return redirect()->back();

        //-------------------------------------------------------
        $user_id = Auth::id();
        $animal_id = $request->input('id');

        $modelExists = UserRequest::where('user_id', $user_id)->where('animal_id', $animal_id)->first() == null;
        $availableForAdoption = Animal::where('id', $animal_id)->where('availability', 'available')->first() != null;

        if($modelExists && $availableForAdoption){

            $userRequest = new UserRequest();
            //$userRequest->user_id = $request->input('user_id');
            $userRequest->user_id = $user_id;
            $userRequest->animal_id = $animal_id;
            //$userRequest->animal_id = 2;
            //$userRequest->request_status = $request->input('request_status');
            $userRequest->request_status = 'waiting_for_approval';
            $userRequest->save();
            //return back()->with('success', 'request made');

            //return view('animals.index', compact('animals'));

            //return redirect()->back()->withSuccess('you have successfully made a request, please wait for approval');
            return redirect()->back()->with('requestsuccess', 'you have successfully made a request, please wait for approval');


          }
          else if(!$modelExists) {
            //dd("record exists and/or is unavailable for request");
            return redirect()->back()->with('modelexists', 'you have already made this request');
          }
          else if(!$availableForAdoption){
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

        dd("store");
        /*
        $user_id = Auth::id();
        $animal_id = $request->input('id');

        $modelExists = UserRequest::where('user_id', $user_id)->where('animal_id', $animal_id)->first() == null;
        $availableForAdoption = Animal::where('id', $animal_id)->where('availability', 'available')->first() != null;

        if($modelExists && $availableForAdoption){

            $userRequest = new UserRequest();
            //$userRequest->user_id = $request->input('user_id');
            $userRequest->user_id = $user_id;
            $userRequest->animal_id = $animal_id;
            //$userRequest->animal_id = 2;
            //$userRequest->request_status = $request->input('request_status');
            $userRequest->request_status = 'waiting_for_approval';
            $userRequest->save();
            //return back()->with('success', 'request made');

            //return view('animals.index', compact('animals'));

            return redirect()->back()->withSuccess('you have successfully made a request, please wait for approval');


          }
          else if($modelExists) {
            //dd("record exists and/or is unavailable for request");
            return redirect()->back()->with('modelexists', 'you have already made this request');
          }
          else if($availableForAdoption){
            return redirect()->back()->with('availableForRequest', 'this animal is not available for request');
          }
          */

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, $id)
    {

        $user_request = UserRequest::
        where('user_id', $request->input('user_id'))->
        where('animal_id', $request->input('animal_id'))->get();

        //$idofentry = UserRequest::select('id')->where('user_id', $request->input('user_id'))->where('animal_id', $request->input('animal_id'))->get();

        //dd($idofentry);
        //dd($user_request);

        foreach ($user_request as $user_request_unit){

          if($user_request_unit['request_status'] == 'waiting_for_approval'){
            $user_request_unit->request_status = $request->input('request_status');
            $user_request_unit->save();
          }
        }

        $user_request = UserRequest::
        where('animal_id', $request->input('animal_id'))->get();
        foreach($user_request as $user_request_unit){
          if($user_request_unit['request_status'] == 'waiting_for_approval'){
            $user_request_unit->request_status = 'denied';
            $user_request_unit->save();
          }
        }

        return redirect()->back()->withSuccess("approved");
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        dd("edit");
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
        $user_request = UserRequest::where('user_id', Auth::id())->where('animal_id', $request->input('animal_id'))->get();
        dd($user_request['animal_id']);

        if($user_request['request_status'] == 'waiting_for_approval'){
          $user_request->request_status = $request->input('request_status');
          $user_request->save();
        }
        redirect()->back();
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

    public function changeRequestStatus(Request $request){
        $user_request = UserRequest::where('user_id', Auth::id())->where('animal_id')->get();

        if($user_request['request_status'] == 'waiting_for_approval'){
          $user_request->request_status = $request->input('request_status');
          $user_request->save();
        }
    }

}
