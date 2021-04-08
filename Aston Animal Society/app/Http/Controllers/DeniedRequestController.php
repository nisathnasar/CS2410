<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\UserRequest;

use Gate;

class DeniedRequestController extends Controller
{
    public function index(){
        if (!Gate::denies('add_animals')) {

            $userRequests = UserRequest::all();
            $userRequests = $userRequests->filter(function($item){
                if($item['request_status'] == 'denied'){
                    return $item;
                }
            }
            )->toArray();
            return view('denied_requests.index', compact('userRequests'));
        }
        else{
            return back();
        }
    }
}
