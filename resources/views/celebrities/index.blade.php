@extends('layouts.default')
@section('content')
    <div class="row justify-content-center mt-3">
        <div class="col-md-12">
            @if ($message = Session::get('success'))
                <div class="alert alert-success" role="alert">
                    {{$message}}
                </div>
            @endif
            <div class="card">
                <div class="card-header">Liste des célébrités</div>
                <div class="card-body">

                    <div class="btn-group gap-3 mb-3">
                        <a href="{{ route('celebrities.create') }}" class="btn btn-success"><i
                                    class="bi bi-plus-circle"></i> Ajouter nouvelle célébrité</a>
                        <form action="{{route('export-celebrities-csv')}} " method="post" target="_blank">
                            @csrf
                            <button type="submit" class="btn btn-info">Export CSV</button>
                        </form>
                        <form action="{{route('export-movies-csv')}} " method="post" target="_blank">
                            @csrf
                            <button type="submit" class="btn btn-info">Export Movies</button>
                        </form>
                    </div>

                    <div class="flex-row">

                        <div class="col-sm">

                        </div>
                    </div>

                    <table class="table table-striped table-bordered">
                        <thead>
                        <tr>
                            <th scope="col">n°</th>
                            <th scope="col">Nom</th>
                            <th scope="col">Prénom</th>
                            <th scope="col">Description</th>
                            <th scope="col">Photo</th>
                            <th scope="col">Films</th>
                        </tr>
                        </thead>
                        <tbody>
                        @forelse ($celebrities as $celebrity)
                            <tr>
                                <th scope="row">{{$loop->iteration}}</th>
                                <td>{{$celebrity->last_name}}</td>
                                <td>{{$celebrity->first_name}}</td>
                                <td>{{$celebrity->description}}</td>
                                <td>
                                    <img src="{{$celebrity->image}}" alt="profile pic {{$celebrity->first_name}}"
                                         height="175px">
                                </td>
                                <td>
                                    @foreach ($celebrity->movies as $movie)
                                        <p>{{$movie->title}}</p>
                                    @endforeach
                                </td>
                                <td>
                                    <form action="{{ route('celebrities.destroy', $celebrity->id) }}" method="post">
                                        @csrf
                                        @method('DELETE')
                                        <a href="{{ route('celebrities.show', $celebrity->id) }}"
                                           class="btn btn-warning btn-sm"><i
                                                    class="bi bi-eye"></i> Show</a>
                                        <a href="{{ route('celebrities.edit', $celebrity->id) }}"
                                           class="btn btn-primary btn-sm"><i
                                                    class="bi bi-pencil-square"></i> Edit</a>
                                        <button type="submit" class="btn btn-danger btn-sm"
                                                onclick="return confirm('Do you want to delete this celebrity?');"><i
                                                    class="bi bi-trash"></i> Delete
                                        </button>
                                    </form>
                                </td>

                            </tr>
                        @empty
                            <td colspan="6">
                            <span class="text-danger">
                                <strong>No celebrity Found!</strong>
                            </span>
                            </td>
                        @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
            {{ $celebrities->links() }}
        </div>
    </div>

@stop