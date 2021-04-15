<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\AdoptionRequest;

use App\Models\Animal;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

use Gate;

class AdoptionRequestController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (!Gate::denies('add_animals')) {

            $adoptionRequests = AdoptionRequest::all();
            $adoptionRequests = $adoptionRequests->toArray();

            //dd($adoptionRequests);



            $sortingDetails = ['sort_by' => 'name',
                'sorting_order' => 'asc',
                'animal_type' => 'all',
                'availability' => 'all',
                'request_status' => 'all'
            ];
            return view('adoption_requests.index', compact('adoptionRequests', 'sortingDetails'));
        }
        else{
            return back();
        }
    }

    public function sortby(Request $request){

        $sort_by = $request->input('sort_by');

        //order by animal name
        if($sort_by == 'animal_name'){
            //perform a left join to order by animal name as it is located in a different table.
            $adoptionRequests = DB::table('adoption_requests')
            ->leftJoin('animals', 'adoption_requests.animal_id', '=', 'animals.id')->orderBy('name', $request->input('sorting_order'))->get(['adoption_requests.*', 'animals.name']);
            //dd($adoptionRequests);
        }
        //order by requester name
        else if($sort_by == 'requester_name'){
            //perform a left join to order by user name as it is located in a different table.
            $adoptionRequests = DB::table('adoption_requests')
            ->leftJoin('users', 'adoption_requests.user_id', '=', 'users.id')->orderBy('name', $request->input('sorting_order'))->get(['adoption_requests.*', 'users.name']);
        }
        //order by requester id
        else if($sort_by == 'requester_id'){
            $adoptionRequests = AdoptionRequest::select('*')->orderBy('user_id', $request->input('sorting_order'))->get();
        }
        //order by animal id
        else if ($sort_by == 'animal_id'){
            $adoptionRequests = AdoptionRequest::select('*')->orderBy('animal_id', $request->input('sorting_order'))->get();
        }

        // //order by requester id
        // if($request->input('sort_by') == 'requester_id'){
        //     $adoptionRequests = AdoptionRequest::select('*')->orderBy('user_id', $request->input('sorting_order'))->get();
        // }
        // //order by animal id
        // else if ($request->input('sort_by') == 'animal_id'){
        //     $adoptionRequests = AdoptionRequest::select('*')->orderBy('animal_id', $request->input('sorting_order'))->get();
        // }

        $availability = $request->input('availability');

        if($availability != 'all'){
            $adoptionRequests = $adoptionRequests->filter(function($item) use ($availability){
                if(Animal::select('availability')->where('id', $item['animal_id'])->get()->first()['availability'] == $availability){
                    return $item;
                }
            });
        }

        $type = $request->input('animal_type');

        if($type != 'all'){
            $adoptionRequests = $adoptionRequests->filter(function($item) use ($type){
                //filter by animal type
                if(Animal::select('animal_type')->where('id', $item['animal_id'])->get()->first()['animal_type'] == $type){
                    return $item;
                }
            });
        }

        $request_status = $request->input('request_status');

        if($request_status != 'all'){
            $adoptionRequests = $adoptionRequests->filter(function($item) use ($request_status){
                //filter by request status
                // if($item['request_status'] == $request_status){
                //     return $item;
                // }
                if($item->request_status == $request_status){
                    return $item;
                }
            });
        }



        $adoptionRequests = $adoptionRequests->toArray();


        //dd($adoptionRequests);

        //convert std class to array
        $adoptionRequests = json_decode(json_encode($adoptionRequests), true);

        //dd(is_a($adoptionRequests, 'Illuminate\Database\Eloquent\Collection'));

        //dd($adoptionRequests);

        $sortingDetails = ['sort_by' => $request->input('sort_by'),
            'sorting_order' => $request->input('sorting_order'),
            'animal_type' => $request->input('animal_type'),
            'availability' => $request->input('availability'),
            'request_status' => $request->input('request_status')
            ];
        return view('adoption_requests.index', compact('adoptionRequests', 'sortingDetails'));
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

        $modelExists = AdoptionRequest::where('user_id', $user_id)->where('animal_id', $animal_id)->first() == null;
        $availableForAdoption = Animal::where('id', $animal_id)->where('availability', 'available')->first() != null;

        if ($modelExists && $availableForAdoption) {

            $adoptionRequest = new AdoptionRequest();
            $adoptionRequest->user_id = $user_id;
            $adoptionRequest->animal_id = $animal_id;
            $adoptionRequest->request_status = 'waiting_for_approval';
            $adoptionRequest->created_at = now();
            $adoptionRequest->save();
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
        $adoptionRequest = AdoptionRequest::where('user_id', $request->input('user_id'))->where('animal_id', $request->input('animal_id'))->get()->first();

        if ($adoptionRequest['request_status'] == 'waiting_for_approval') {
            $adoptionRequest->request_status = $request->input('request_status');
            $adoptionRequest->updated_at = now();
            $adoptionRequest->save();
        }

        if ($request->input('request_status') == 'approved') {
            $animal = Animal::where('id', $request->input('animal_id'))->get()->first();
            $animal->adopted_by = $request->input('user_id');
            $animal->availability = 'unavailable';
            $animal->updated_at = now();
            $animal->save();
        }


        //if an animal has been adopted by 1 person, deny all other request to this animal.
        //get all requests to $request->input('animal_id')
        $adoptionRequests = AdoptionRequest::where('animal_id', $request->input('animal_id'))->get();
        //if user clicked approve and not deny
        if ($request->input('request_status') != 'denied') {
            //for each request, change status to denied.
            foreach ($adoptionRequests as $adoptionRequestUnit) {
                if ($adoptionRequestUnit['request_status'] == 'waiting_for_approval') {
                    $adoptionRequestUnit->request_status = 'denied';
                    $adoptionRequestUnit->updated_at = now();
                    $adoptionRequestUnit->save();
                }
            }
        }

        $endingmsg = '.';

        if ($request->input('request_status') == 'approved') {
            $endingmsg = ' and denied adoption request to this animal from any other users (if any). Click "Adopted Animals" in menu to view approved requests.';
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

    public function deniedRequests(){
        if (!Gate::denies('add_animals')) {

            $adoptionRequests = AdoptionRequest::all();
            $adoptionRequests = $adoptionRequests->filter(function($item){
                if($item['request_status'] == 'denied'){
                    return $item;
                }
            }
            )->toArray();
            return view('denied_requests.deniedrequests', compact('adoptionRequests'));
        }
        else{
            return back();
        }
    }

    public function myAdoptionRequests(){
        $adoptionRequests = AdoptionRequest::all();
        $adoptionRequests = $adoptionRequests->filter(
            function ($item) {
                if ($item['user_id'] == Auth::id()) {
                    return $item;
                }
            }
        )->toArray();

        return view('adoption_requests.my_adoption_requests.myadoptionrequests', compact('adoptionRequests'));
    }

}
