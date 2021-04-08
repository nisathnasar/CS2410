<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Animal;
use Gate;

class AdoptedAnimalController extends Controller
{
    public function index()
    {
        if (!Gate::denies('add_animals')) {
            $animals = Animal::all();
            $animals = $animals->filter(
                function ($item) {
                    if ($item['adopted_by'] != null) {
                        return $item;
                    }
                }
            )->toArray();
            return view('adopted_animals.index', compact('animals'));
        } else{
            return back();
        }
    }
}
