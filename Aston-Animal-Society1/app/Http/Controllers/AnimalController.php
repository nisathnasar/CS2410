<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Animal;

use Gate;

class AnimalController extends Controller
{

    public function index(){

        $animals = Animal::select('*')->orderBy('name')->get()->toArray();
        $sortingDetails = ['sort_by' => 'name',
        'sorting_order' => 'asc',
        'animal_type' => 'all',
        'availability' => 'all'];

        return view('animals.index', compact('animals', 'sortingDetails'));
    }

    public function sortby(Request $request){

        $animals = Animal::select('*')->orderBy($request->input('sort_by'), $request->input('sorting_order'))->get();

        $availability = $request->input('availability');

        if($availability != 'all'){
            $animals = $animals->filter(function($item) use ($availability){
                if($item['availability'] == $availability){
                    return $item;
                }
            });
        }

        $type = $request->input('animal_type');

        if($type != 'all'){
            $animals = $animals->filter(function($item) use ($type){
                if($item['animal_type'] == $type){
                    return $item;
                }
            });
        }

        $animls = $animals->toArray();
        $sortingDetails = [
            'sort_by' => $request->input('sort_by'),
            'sorting_order' => $request->input('sorting_order'),
            'animal_type' => $request->input('animal_type'),
            'availability' => $request->input('availability')
            ];
        return view('animals.index', compact('animals', 'sortingDetails'));
    }

    public function adoptedAnimals(){
        if (!Gate::denies('add_animals')) {
            $animals = Animal::all();
            $animals = $animals->filter(function ($item) {
                    if ($item['adopted_by'] != null) {
                        return $item;
                    }
                })->toArray();
            return view('animals.adopted_animals.adoptedanimals', compact('animals'));
        } else{
            return back();
        }
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
            'image' => 'sometimes|image|mimes:jpeg,png,jpg,gif,svg|max:500',
            'image2' => 'sometimes|image|mimes:jpeg,png,jpg,gif,svg|max:500',
            'image3' => 'sometimes|image|mimes:jpeg,png,jpg,gif,svg|max:500'

        ]);

        if($request->hasFile('image')){                                                     //Handles the uploading of the image
            $fileNameWithExt = $request->file('image')->getClientOriginalName();            //Gets the filename with the extension
            $filename = pathinfo($fileNameWithExt, PATHINFO_FILENAME);                      //just gets the filename
            $extension = $request->file('image')->getClientOriginalExtension();             //Just gets the extension
            $fileNameToStore = $filename.'_'.time().'.'.$extension;                         //Gets the filename to store
            $path = $request->file('image')->storeAs('public/images', $fileNameToStore);    //Uploads the image
            }
        else{
            $fileNameToStore = 'noimage.jpg';
        }

        if($request->hasFile('image2')){
            $fileNameWithExt = $request->file('image2')->getClientOriginalName();
            $filename = pathinfo($fileNameWithExt, PATHINFO_FILENAME);
            $extension = $request->file('image2')->getClientOriginalExtension();
            $fileNameToStore2 = $filename.'_'.time().'.'.$extension;
            $path = $request->file('image2')->storeAs('public/images', $fileNameToStore2);
            }
        else{
            $fileNameToStore2 = 'noimage.jpg';
        }

        if($request->hasFile('image3')){
            $fileNameWithExt = $request->file('image3')->getClientOriginalName();
            $filename = pathinfo($fileNameWithExt, PATHINFO_FILENAME);
            $extension = $request->file('image3')->getClientOriginalExtension();
            $fileNameToStore3 = $filename.'_'.time().'.'.$extension;
            $path = $request->file('image3')->storeAs('public/images', $fileNameToStore3);
            }
        else{
            $fileNameToStore3 = 'noimage.jpg';
        }

        $animal = new Animal;
        $animal->name = $request->input('name');
        $animal->date_of_birth = $request->input('date_of_birth');
        $animal->description = $request->input('description');
        $animal->animal_type = $request->input('animal_type');
        $animal->availability = $request->input('availability');
        $animal->created_at = now();
        $animal->image = $fileNameToStore;
        $animal->image2 = $fileNameToStore2;
        $animal->image3 = $fileNameToStore3;
        $animal->save();
        return back()->with('success', 'Animal has been added');

    }



    public function destroy($id){
        if (!Gate::denies('add_animals')) {
            \App\Models\AdoptionRequest::where('animal_id', $id)->delete();
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
            'date_of_birth' => 'required'
        ]);
        $animal->name = $request->input('name');
        $animal->date_of_birth = $request->input('date_of_birth');
        $animal->description = $request->input('description');
        $animal->availability = $request->input('availability');

        $animal->updated_at = now();

        if ($request->hasFile('image')){
            $fileNameWithExt = $request->file('image')->getClientOriginalName();
            $filename = pathinfo($fileNameWithExt, PATHINFO_FILENAME);
            $extension = $request->file('image')->getClientOriginalExtension();
            $fileNameToStore = $filename.'_'.time().'.'.$extension;
            $path = $request->file('image')->storeAs('public/images', $fileNameToStore);
            $animal->image = $fileNameToStore;
        }

        if($request->hasFile('image2')){
            $fileNameWithExt = $request->file('image2')->getClientOriginalName();
            $filename = pathinfo($fileNameWithExt, PATHINFO_FILENAME);
            $extension = $request->file('image2')->getClientOriginalExtension();
            $fileNameToStore2 = $filename.'_'.time().'.'.$extension;
            $path = $request->file('image2')->storeAs('public/images', $fileNameToStore2);
            $animal->image2 = $fileNameToStore2;
        }

        if($request->hasFile('image3')){
            $fileNameWithExt = $request->file('image3')->getClientOriginalName();
            $filename = pathinfo($fileNameWithExt, PATHINFO_FILENAME);
            $extension = $request->file('image3')->getClientOriginalExtension();
            $fileNameToStore3 = $filename.'_'.time().'.'.$extension;
            $path = $request->file('image3')->storeAs('public/images', $fileNameToStore3);
            $animal->image3 = $fileNameToStore3;
        }

        $animal->save();
        return redirect('animals');
    }



}
