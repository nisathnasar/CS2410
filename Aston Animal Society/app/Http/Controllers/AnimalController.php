<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Animal;

use Gate;

class AnimalController extends Controller
{

    public function index(){

        $animals = Animal::select('*')->orderBy('name')->get();
        $animals = $animals->filter(function($item){
            if($item['availability'] == 'Available'){
                return $item;
            }
        }
        )->toArray();

        $sortingDetails = ['sort_by' => 'name', 'sorting_order' => 'asc'];

        return view('animals.index', compact('animals', 'sortingDetails'));
    }

    public function sortby(Request $request){

        $animals = Animal::select('*')->orderBy($request->input('sort_by'), $request->input('sorting_order'))->get();
        $animals = $animals->filter(function($item){
            if($item['availability'] == 'Available'){
                return $item;
            }
        }
        )->toArray();
        $sortingDetails = ['sort_by' => $request->input('sort_by'), 'sorting_order' => $request->input('sorting_order')];
        return view('animals.index', compact('animals', 'sortingDetails'));
    }

    public function show($id){
        $animal = Animal::find($id);
        return view('animals.show', compact('animal'));
    }

    public function create(){

        $accountsQuery = Animal::all();
        if(!Gate::denies('add_animals')){
            return view('animals.create', array('animals'=>$accountsQuery));
        }

    }

    public function store(Request $request){
        // form validation
        $animal = $this->validate(request(), [
            'name' => 'required',
            'date_of_birth' => 'required',
            'image' => 'sometimes|image|mimes:jpeg,png,jpg,gif,svg|max:500'
        ]);
        //Handles the uploading of the image
        if($request->hasFile('image')){
            //Gets the filename with the extension
            $fileNameWithExt = $request->file('image')->getClientOriginalName();
            //just gets the filename
            $filename = pathinfo($fileNameWithExt, PATHINFO_FILENAME);
            //Just gets the extension
            $extension = $request->file('image')->getClientOriginalExtension();
            //Gets the filename to store
            $fileNameToStore = $filename.'_'.time().'.'.$extension;
            //Uploads the image
            $path = $request->file('image')->storeAs('public/images', $fileNameToStore);
            }
        else{
            $fileNameToStore = 'noimage.jpg';
        }

        // create a animal object and set its values from the input
        $animal = new Animal;
        $animal->name = $request->input('name');
        $animal->date_of_birth = $request->input('date_of_birth');
        $animal->description = $request->input('description');
        $animal->availability = $request->input('availability');
        $animal->created_at = now();
        $animal->image = $fileNameToStore;
        // save the animal object
        $animal->save();
        // generate a redirect HTTP response with a success message
        return back()->with('success', 'Animal has been added');

    }



    public function destroy($id){
        if (!Gate::denies('add_animals')) {
            $animal = Animal::find($id);
            $animal->delete();
            return redirect('animals');
        }
    }

    public function edit($id){
        if(!Gate::denies('add_animals')){
            $animal = Animal::find($id);
            return view('animals.edit', compact('animal'));
        }
    }

    public function update(Request $request, $id){
        $animal = Animal::find($id);
        $this->validate(request(), [
            'name' => 'required',
            'date_of_birth' => 'required|numeric'
        ]);
        $animal->name = $request->input('name');
        $animal->date_of_birth = $request->input('date_of_birth');
        $animal->description = $request->input('description');
        $animal->availability = $request->input('availability');
        //$animal->image = $request->input('image');
        $animal->updated_at = now();
        //Handles the uploading of the image
        if ($request->hasFile('image')){
        //Gets the filename with the extension
        $fileNameWithExt = $request->file('image')->getClientOriginalName();
        //just gets the filename
        $filename = pathinfo($fileNameWithExt, PATHINFO_FILENAME);
        //Just gets the extension
        $extension = $request->file('image')->getClientOriginalExtension();
        //Gets the filename to store
        $fileNameToStore = $filename.'_'.time().'.'.$extension;
        //Uploads the image
        $path = $request->file('image')->storeAs('public/images', $fileNameToStore);
        } else {
        $fileNameToStore = 'noimage.jpg';
        }
        $animal->image = $fileNameToStore;
        $animal->save();
        return redirect('animals');
    }



}
