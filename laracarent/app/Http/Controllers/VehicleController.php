<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Vehicle;

class VehicleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $vehicles = Vehicle::all()->toArray();
        return view('vehicles.index', compact('vehicles'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('vehicles.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //form validation
        $vehicle = $this->validate(request(), [
            'reg_no' => 'required',
            'daily_rate' => 'required|numeric',
            'image' => 'sometimes|image|mimes:jpeg,png,jpg,gif,svg|max:500',
        ]);

        //Handles the uploading of the image
        if($request->hasFile('image')){
            //Gets the filename with the extension
            $fileNameWithExt = $request->file('image')->getClientOriginalName();
            //just gets the filename
            $filename = pathinfo($fileNameWithExt, PATHINFO_FILENAME);
            //just gets the extension
            $extension = $request->$file('image')->getClientOriginalExtension();
            //Getst he filename to store
            $fileNameToStore = $filename.'_'.time().'.'.$extension;

            //uploads the image
            $path = $request->file('image')->storeAs('public/images', $fileNameToStore);
        }
        else{
            $fileNameToStore = 'noimage.jpg';
        }
        $vehicle = new Vehicle;
        $vehicle->reg_no = $request->input('reg_no');
        $vehicle->description = $request->input('description');
        $vehicle->brand = $request->input('brand');
        $vehicle->daily_rate = $request->input('daily_rate');
        $vehicle->category = $request->input('category');
        $vehicle->created_at = now();
        $vehicle->image = $fileNameToStore;

        //save the Vehicle object
        $vehicle->save();
        //generate a redirect HTTP response with a success message
        return back()->with('success', 'Vehicle has been added');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $vehicle = Vehicle::find($id);
        return view('vehicles.show', compact('vehicle'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $vehicle = Vehicle::find($id);
        return view('vehicles.edit', compact('vehicle'));
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
        $vehicle = Vehicle::find($id);
        $this->validate(request(), [
            'reg_no' => 'required',
            'daily_rate' => 'required|numeric'
        ]);
        $vehicle->reg_no = $request->input('reg_no');
        $vehicle->description = $request->input('description');
        $vehicle->brand = $request->input('brand');
        $vehicle->daily_rate = $request->input('daily_rate');
        $vehicle->category = $request->input('category');
        $vehicle->updated_at = now();
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
        } 
        else {
            $fileNameToStore = 'noimage.jpg';
        }
        $vehicle->image = $fileNameToStore;
        $vehicle->save();
        return redirect('vehicles');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $vehicle = Vehicle::find($id);
        $vehicle = delete();
        return redirect('vehicles');
    }
}
