@extends('layouts.default')

@section('title', 'Edit celeb')
@section('content')
    <div class="row justify-content-center mt-3">
        <div class="col-md-8">

            @if ($message = Session::get('success'))
                <div class="alert alert-success" role="alert">
                    {{ $message }}
                </div>
            @endif

            <div class="card">
                <div class="card-header">
                    <div class="float-start">
                        Modifier le wiki
                    </div>
                    <div class="float-end">
                        <a href="{{ route('celebrities.index') }}" class="btn btn-primary btn-sm">&larr; Retour</a>
                    </div>
                </div>
                <div class="card-body">
                    <form action="{{ route('celebrities.update', $celebrity->id) }}" method="post">
                        @csrf
                        @method("PUT")

                        <div class="mb-3 row">
                            <label for="last_name" class="col-md-4 col-form-label text-md-end text-start">Nom</label>
                            <div class="col-md-6">
                                <input type="text" class="form-control @error('last_name') is-invalid @enderror"
                                       id="last_name"
                                       name="last_name" value="{{ $celebrity->last_name }}">
                                @if ($errors->has('last_name'))
                                    <span class="text-danger">{{ $errors->first('last_name') }}</span>
                                @endif
                            </div>
                        </div>

                        <div class="mb-3 row">
                            <label for="first_name"
                                   class="col-md-4 col-form-label text-md-end text-start">Prénom</label>
                            <div class="col-md-6">
                                <input type="text" class="form-control @error('first_name') is-invalid @enderror"
                                       id="first_name"
                                       name="first_name" value="{{ $celebrity->first_name }}">
                                @if ($errors->has('first_name'))
                                    <span class="text-danger">{{ $errors->first('first_name') }}</span>
                                @endif
                            </div>
                        </div>

                        <div class="mb-3 row">
                            <label for="image" class="col-md-4 col-form-label text-md-end text-start">Photo</label>
                            <div class="col-md-6">
                                <input type="text" class="form-control @error('image') is-invalid @enderror"
                                       id="image"
                                       name="image" value="{{ $celebrity->image }}">
                                @if ($errors->has('image'))
                                    <span class="text-danger">{{ $errors->first('image') }}</span>
                                @endif
                            </div>
                        </div>

                        <div class="mb-3 row">
                            <label for="description"
                                   class="col-md-4 col-form-label text-md-end text-start">Description</label>
                            <div class="col-md-6">
                            <textarea class="form-control @error('description') is-invalid @enderror" id="description"
                                      name="description">{{ $celebrity->description }}</textarea>
                                @if ($errors->has('description'))
                                    <span class="text-danger">{{ $errors->first('description') }}</span>
                                @endif
                            </div>
                        </div>

                        <div class="mb-3 row">
                            <input type="submit" class="col-md-3 offset-md-5 btn btn-primary" value="Rendre famouss">
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@stop
