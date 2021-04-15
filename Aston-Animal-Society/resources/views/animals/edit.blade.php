@extends('layouts.app')
@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8 ">
            <div class="card">
                <div class="card-header">Edit Details</div>

                @if ($errors->any())

                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)

                        <li>{{ $error }}</li>

                        @endforeach
                    </ul>
                </div><br />

                @endif
                @if (\Session::has('success'))

                <div class="alert alert-success">
                    <p>{{ \Session::get('success') }}</p>
                </div><br />

                @endif

                <div class="card-body">
                    <form class="form-horizontal" method="POST" action="{{ route('animals.update', ['animal' => $animal['id']]) }}" enctype="multipart/form-data" >

                        @method('PATCH')
                        @csrf



                    <div>

                        @if ($animal->image != 'noimage.jpg' || $animal->image2 != 'noimage.jpg' || $animal->image3 != 'noimage.jpg')
                            <div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel"
                                style="padding-bottom: 10px">
                                <ol class="carousel-indicators">
				    @if ($animal->image != 'noimage.jpg')
                                        <li data-target="#carouselExampleIndicators" data-slide-to="0" class="active"></li>
				    @endif
                                    @if ($animal->image2 != 'noimage.jpg')
                                        <li data-target="#carouselExampleIndicators" data-slide-to="1" class="active"></li>
                                    @endif
                                    @if ($animal->image3 != 'noimage.jpg')
                                        <li data-target="#carouselExampleIndicators" data-slide-to="2"></li>
                                    @endif
                                </ol>
                                <div class="carousel-inner">
                                    @if ($animal->image != 'noimage.jpg')
                                    	<div class="carousel-item active">
                                        	<img class="d-block w-100" height="400px" style="max-width: 100%"
	                                            src="{{ asset('storage/images/' . $animal->image) }}" alt="First slide">
        	                        </div>
				    @endif
                                    @if ($animal->image2 != 'noimage.jpg')
                                        <div class="carousel-item @if ($animal->image == 'noimage.jpg') active @endif">
                                            <img class="d-block w-100" height="400px" style="max-width: 100%"
                                                src="{{ asset('storage/images/' . $animal->image2) }}" alt="Second slide">
                                        </div>
                                    @endif
                                    @if ($animal->image3 != 'noimage.jpg')
                                        <div class="carousel-item @if ($animal->image == 'noimage.jpg' && $animal->image2 == 'noimage.jpg') active @endif">
                                            <img class="d-block w-100" height="400px" width="auto"
                                                src="{{ asset('storage/images/' . $animal->image3) }}" alt="Third slide">
                                        </div>
                                    @endif
                                </div>
                                <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button"
                                    data-slide="prev">
                                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                    <span class="sr-only">Previous</span>
                                </a>
                                <a class="carousel-control-next" href="#carouselExampleIndicators" role="button"
                                    data-slide="next">
                                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                    <span class="sr-only">Next</span>
                                </a>
                            </div>

                        @endif

                        </div>

                        <div class="col-md-8">
                            <label ><strong>Name</strong></label>
                            <input type="text" name="name" value="{{$animal->name}}"/>
                        </div>

                        <div class="col-md-8">
                            <label ><strong>Date of Birth</strong></label>
                            <input type="date" name="date_of_birth" value="{{$animal->date_of_birth}}" />
                        </div>

                        <div class="col-md-8">
                            <label ><strong>Description</strong></label>
                            <textarea rows="4" cols="50" name="description" > {{$animal->description}}</textarea>
                        </div>
                        <div class="col-md-8">
                            <label ><strong>Type of Animal</strong></label>
                            <select name="animal_type">
                                <option value="cat" @if($animal->animal_type == 'cat') selected @endif>Cat</option>
                                <option value="dog" @if($animal->animal_type == 'dog') selected @endif>Dog</option>
                                <option value="bird" @if($animal->animal_type == 'bird') selected @endif>Bird</option>
                                <option value="fish" @if($animal->animal_type == 'fish') selected @endif>Fish</option>
                                <option value="reptile" @if($animal->animal_type == 'reptile') selected @endif>Reptile</option>
                                <option value="horse" @if($animal->animal_type == 'horse') selected @endif>Horse</option>
                                <option value="other" @if($animal->animal_type == 'other') selected @endif>Other</option>
                            </select>
                        </div>
                        <div class="col-md-8">
                            <label><strong>Availability</strong></label>
                            <select name="availability" value="{{ $animal->availability }}">
                                <option value="available">Available</option>
                                <option value="unavailable">Unavailable</option>
                            </select>
                        </div>
                        <div class="col-md-8">
                            <label><strong>Image - up to 3 images supported</strong></label><br>
                            <input type="file" name="image" placeholder="Image file" /><br>
			    <label>
			    @if ($animal->image != 'noimage.jpg')
			    	{{$animal->image}}
			    @else
			    No Image
			    @endif
			    </label><br>

                            <input type="file" name="image2" placeholder="Image file" /><br>
			    <label>
			    @if ($animal->image2 != 'noimage.jpg')
			    	{{$animal->image2}}
			    @else
			    	No Image
			    @endif
			    </label><br>

                            <input type="file" name="image3" placeholder="Image file" /><br>
			    <label>
			    @if ($animal->image3 != 'noimage.jpg')
			    	{{$animal->image3}}
			    @else
			    	No Image
			    @endif
			    </label><br>

                        </div>
                        <div class="col-md-6 col-md-offset-4">
                            <input type="submit" class="btn btn-primary" />
                            <input type="reset" class="btn btn-primary" />
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
