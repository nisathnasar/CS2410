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
     * Display a listing of the adoption requests.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //if user is an admin
        if (!Gate::denies('add_animals')) {
            // get all entries
            $adoptionRequests = AdoptionRequest::all();
            // convert to array
            $adoptionRequests = $adoptionRequests->toArray();
            //pass preset information for sorting and filtering
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

    /**
     * sorting and filtering for index view
     */
    public function sortby(Request $request){
        //if user is an admin
        if (!Gate::denies('add_animals')) {
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

            //order by requester id
            if($request->input('sort_by') == 'requester_id'){
                $adoptionRequests = AdoptionRequest::select('*')->orderBy('user_id', $request->input('sorting_order'))->get();
            }
            //order by animal id
            else if ($request->input('sort_by') == 'animal_id'){
                $adoptionRequests = AdoptionRequest::select('*')->orderBy('animal_id', $request->input('sorting_order'))->get();
            }

            $availability = $request->input('availability');

            if($availability != 'all'){
                //filter availability as chosen
                $adoptionRequests = $adoptionRequests->filter(function($item) use ($availability){
                    if(Animal::select('availability')->where('id', $item->animal_id)->get()->first()['availability'] == $availability){
                        return $item;
                    }
                });
            }

            $type = $request->input('animal_type');

            if($type != 'all'){
                //filter animal type as chosen
                $adoptionRequests = $adoptionRequests->filter(function($item) use ($type){
                    if(Animal::select('animal_type')->where('id', $item->animal_id)->get()->first()['animal_type'] == $type){
                        return $item;
                    }
                });
            }

            $request_status = $request->input('request_status');

            if($request_status != 'all'){
                //filter request status as chosen
                $adoptionRequests = $adoptionRequests->filter(function($item) use ($request_status){
                    if($item->request_status == $request_status){
                        return $item;
                    }
                });
            }

            //convert collection to array
            $adoptionRequests = $adoptionRequests->toArray();

            //convert to string and back to array to make sure they're done properly.
            $adoptionRequests = json_decode(json_encode($adoptionRequests), true);

            //populate the sorting and filtering drop downs so users can see what option they selected before clicking 'apply'
            $sortingDetails = ['sort_by' => $request->input('sort_by'),
                'sorting_order' => $request->input('sorting_order'),
                'animal_type' => $request->input('animal_type'),
                'availability' => $request->input('availability'),
                'request_status' => $request->input('request_status')
                ];

            return view('adoption_requests.index', compact('adoptionRequests', 'sortingDetails'));
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        //if user is a normal user
        if (Gate::denies('add_animals')) {

            //id of user
            $user_id = Auth::id();

            //id of animal
            $animal_id = $request->input('id');

            //check if the request hasn't already been made
            $modelExists = AdoptionRequest::where('user_id', $user_id)->where('animal_id', $animal_id)->doesntExist();

            //check if the animal is available
            $availableForAdoption = Animal::where('id', $animal_id)->where('availability', 'available')->exists();

            if ($modelExists && $availableForAdoption) {
                //new entry
                $adoptionRequest = new AdoptionRequest();
                //id of current user
                $adoptionRequest->user_id = $user_id;
                //id of animal request is being made for
                $adoptionRequest->animal_id = $animal_id;
                //set status to waiting for approval
                $adoptionRequest->request_status = 'waiting_for_approval';
                //record time
                $adoptionRequest->created_at = now();
                //save
                $adoptionRequest->save();
                //success message
                return redirect()->back()->with('requestsuccess', 'you have successfully made a request, please wait for approval');
            } else if (!$modelExists) {
                //if request is already made then return message
                return redirect()->back()->with('modelexists', 'you have already made this request');
            } else if (!$availableForAdoption) {
                //if animal is not available then return message
                return redirect()->back()->with('availableforrequest', 'this animal is not available for request');
            }
        }
    }

    /**
     * Approve or Deny a request
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //only staff or admin can approve or deny
        if (!Gate::denies('add_animals')) {
            //find the record
            $adoptionRequest = AdoptionRequest::where('user_id', $request->input('user_id'))->where('animal_id', $request->input('animal_id'))->get()->first();

            //if status is waiting for approval, then change status as requested
            if ($adoptionRequest['request_status'] == 'waiting_for_approval') {
                $adoptionRequest->request_status = $request->input('request_status');
                $adoptionRequest->updated_at = now();
                $adoptionRequest->save();
            }

            //if user is approving for a request, then make the animal unavailable
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

            //feedback message constructed based on the input
            return redirect()->back()->with('approvemsg', 'Successfully '
                    . $request->input('request_status')
                    . ' adoption request for user id: '
                    . $request->input('user_id')
                    . ' with animal id: '
                    . $request->input('animal_id')
                    . $endingmsg);
        }
    }


    /**
     * myAdoptionRequests view
     */
    public function myAdoptionRequests(){
        //if user is normal user
        if (Gate::denies('add_animals')) {
            //get all adoption requests
            $adoptionRequests = AdoptionRequest::all();
            //filter the user's requests
            $adoptionRequests = $adoptionRequests->filter(
                function ($item) {
                    if ($item['user_id'] == Auth::id()) {
                        return $item;
                    }
                }
            )->toArray();

            //preset sorting and filtering data
            $sortingDetails = ['sort_by' => 'name',
                    'sorting_order' => 'asc',
                    'animal_type' => 'all',
                    'availability' => 'all',
                    'request_status' => 'all'
                ];

            return view('adoption_requests.my_adoption_requests.myadoptionrequests', compact('adoptionRequests', 'sortingDetails'));
        }
    }

    /**
     * sorting and filtering for myAdoptionRequests view
     */
    public function sortAndFilterMyAdoptionRequests(Request $request){
        //if user is a normal user
        if (Gate::denies('add_animals')) {

            $sort_by = $request->input('sort_by');

            if($sort_by == 'animal_name'){
                //perform a left join to order by animal name as it is located in a different table.
                $adoptionRequests = DB::table('adoption_requests')
                ->leftJoin('animals', 'adoption_requests.animal_id', '=', 'animals.id')->orderBy('name', $request->input('sorting_order'))->get(['adoption_requests.*', 'animals.name']);
            }

            else if ($sort_by == 'animal_id'){
                //order by animal id
                $adoptionRequests = AdoptionRequest::select('*')->orderBy('animal_id', $request->input('sorting_order'))->get();
            }

            $type = $request->input('animal_type');

            if($type != 'all'){
                //filter animal type requested from the input.
                $adoptionRequests = $adoptionRequests->filter(function($item) use ($type){
                    if(Animal::select('animal_type')->where('id', $item->animal_id)->get()->first()['animal_type'] == $type){
                        return $item;
                    }
                });
            }

            $request_status = $request->input('request_status');

            if($request_status != 'all'){
                //filter animal request status as requested from the input.
                $adoptionRequests = $adoptionRequests->filter(function($item) use ($request_status) {
                    if($item->request_status == $request_status){
                        return $item;
                    }
                });
            }

            $adoptionRequests = $adoptionRequests->filter(function($item) {
                //filter requests that belong to current user.
                if($item->user_id == Auth::id()){
                    return $item;
                }
            });

            //convert the collection to array
            $adoptionRequests = $adoptionRequests->toArray();

            //convert to string and to array to make sure it's done properly.
            $adoptionRequests = json_decode(json_encode($adoptionRequests), true);

            //populate the sorting and filtering drop downs so users can see what option they selected before clicking 'apply'
            $sortingDetails = ['sort_by' => $request->input('sort_by'),
                'sorting_order' => $request->input('sorting_order'),
                'animal_type' => $request->input('animal_type'),
                'request_status' => $request->input('request_status')
                ];

            return view('adoption_requests.my_adoption_requests.myadoptionrequests', compact('adoptionRequests', 'sortingDetails'));
        }
    }

}

