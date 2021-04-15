@extends('layouts.app')
@section('content')
    <div class="container-fluid">
        <div class="row justify-content-center">
            <div class="col-md-8 ">
                <div class="card overflow-hidden">
                    <div class="card-header">Adopted Animals - List of Adoptee and Adotpers</div>
                    <div class="card-body">


			<div class="container">
                            <div class="row justify-content-end">
                                <form action="{{ action([App\Http\Controllers\AnimalController::class, 'sortAndFilterAdoptedAnimals']) }}">
                                    @csrf
                                    <label for="sort_by">Sort by</label>
                                    <select name="sort_by" id="">
                                        <option value="name" @if ($sortingDetails['sort_by'] == 'name') selected @endif>
                                            Name
                                        </option>
                                        <option value="id" @if ($sortingDetails['sort_by'] == 'id') selected @endif>
                                            Animal ID
                                        </option>
                                        <option value="date_of_birth" @if ($sortingDetails['sort_by'] == 'date_of_birth') selected @endif>
                                            Date of Birth
                                        </option>
                                    </select>
                                    <select name="sorting_order" id="">
                                        <option value="asc" @if ($sortingDetails['sorting_order'] == 'asc') selected @endif>
                                            Ascending
                                        </option>
                                        <option value="desc" @if ($sortingDetails['sorting_order'] == 'desc') selected @endif>
                                            Descending
                                        </option>
                                    </select>
                                    <label >Filters</label>

                                    <select name="animal_type" id="">
                                        <option value="all" @if ($sortingDetails['animal_type'] == 'all') selected @endif>
                                            All
                                        </option>
                                        <option value="cat" @if ($sortingDetails['animal_type'] == 'cat') selected @endif>
                                            cats
                                        </option>
                                        <option value="dog" @if ($sortingDetails['animal_type'] == 'dog') selected @endif>
                                            dogs
                                        </option>
                                        <option value="bird" @if ($sortingDetails['animal_type'] == 'bird') selected @endif>
                                            birds
                                        </option>
                                        <option value="fish" @if ($sortingDetails['animal_type'] == 'fish') selected @endif>
                                            fishes
                                        </option>
                                        <option value="reptile" @if ($sortingDetails['animal_type'] == 'reptile') selected @endif>
                                            reptiles
                                        </option>
                                        <option value="horse" @if ($sortingDetails['animal_type'] == 'horse') selected @endif>
                                            horses
                                        </option>
                                        <option value="other" @if ($sortingDetails['animal_type'] == 'other') selected @endif>
                                            other animals
                                        </option>
                                    </select>
                                    <button class="btn btn-info" type="submit">Apply</button>
                                </form>
                            </div>
                        </div>





                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th></th>
                                    <th>Animal ID</th>
                                    <th>Name</th>
                                    <th>Date of Birth</th>
                                    <th>Description</th>
                                    <th>Animal Type</th>
                                    <th>Adopter ID</th>
                                    <th>Adopter</th>
                                    <th colspan="1"></th>

                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($animals as $animal)
                                    <tr>
                                        <td colspan='1'>
                                            <img style="width:55px;height:55px"
                                                @if ($animal['image'] != 'noimage.jpg')
                                                    src="{{ asset('storage/images/' . $animal['image']) }}"
                                                @elseif ($animal['image2'] != 'noimage.jpg')
                                                    src="{{ asset('storage/images/' . $animal['image2']) }}"
                                                @else
                                                    src="{{ asset('storage/images/' . $animal['image3']) }}"
                                                @endif >

                                        </td>

                                        <td class="align-middle text-center">{{ $animal['id'] }}</td>
                                        <td class="align-middle">{{ $animal['name'] }}</td>
                                        <td class="align-middle">{{ $animal['date_of_birth'] }}</td>
                                        <td class="align-middle">{{ $animal['description'] }}</td>
                                        <td class="align-middle">{{ $animal['animal_type'] }}</td>
                                        <td class="align-middle">{{ $animal['adopted_by']}}</td>
                                        <td class="align-middle">{{ App\Models\User::find($animal['adopted_by'])['name'] }}</td>
                                        <td class="align-middle"><a class="btn btn-secondary"href="{{ route('animals.show', ['animal' => $animal['id']]) }}" class="btn btnprimary">Details</a></td>

                                    </tr>

                                @endforeach

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
