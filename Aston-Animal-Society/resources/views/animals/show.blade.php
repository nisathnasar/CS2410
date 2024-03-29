@extends('layouts.app')
@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8 ">
                <div class="card">
                    <div class="card-header">Display all animals</div>
                    <div class="card-body">
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

                        <table class="table table-striped" border="1">
                            <tr>
                                <th> <b>Animal name </th>
                                <td> {{ $animal['name'] }}</td>
                            </tr>
                            <tr>
                                <th>Date of Birth </th>
                                <td>{{ $animal->date_of_birth }}</td>
                            </tr>
                            <tr>
                                <th>Description </th>
                                <td>{{ $animal->description }}</td>
                            </tr>
                            <tr>
                                <th>Animal Type</th>
                                <td>{{ $animal->animal_type }}</td>
                            </tr>
                            <tr>
                                <th>Availability </th>
                                <td>{{ $animal->availability }}</td>
                            </tr>


                        </table>
                        <table>
                            <tr>
                                <td><a href="{{ route('animals.index') }}" class="btn btn-primary" role="button">Back to the
                                        list</a></td>

                                @if (!Gate::denies('add_animals'))

                                    <td><a href="{{ route('animals.edit', ['animal' => $animal['id']]) }}"
                                            class="btn btnwarning">Edit</a></td>
                                    <td>
                                        <form action="{{ route('animals.destroy', ['animal' => $animal['id']]) }}"
                                            method="post">
                                            @csrf
                                            <input name="_method" type="hidden" value="DELETE">
                                            <button class="btn btn-danger" type="submit">Delete</button>
                                        </form>
                                    </td>

                                @endif

                            </tr>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
