@extends('layouts.default')
@section('content')
    <div class="row justify-content-center mt-3">
        <div class="col-md-8">

            <div class="card">
                <div class="card-header">
                    <div class="float-start">
                        Infos sur la célébrité
                    </div>
                    <div class="float-end">
                        <a href="{{ route('celebrities.index') }}" class="btn btn-primary btn-sm">&larr; retour</a>
                    </div>
                </div>
                <div class="card-body">

                    <div class="row">
                        <label for="last_name"
                               class="col-md-4 col-form-label text-md-end text-start"><strong>Nom:</strong></label>
                        <div class="col-md-6" style="line-height: 35px;">
                            {{ $celebrity->last_name }}
                        </div>
                    </div>

                    <div class="row">
                        <label for="first_name"
                               class="col-md-4 col-form-label text-md-end text-start"><strong>Prénom:</strong></label>
                        <div class="col-md-6" style="line-height: 35px;">
                            {{ $celebrity->first_name }}
                        </div>
                    </div>

                    <div class="row">
                        <label for="quantity"
                               class="col-md-4 col-form-label text-md-end text-start"><strong>Photo:</strong></label>
                        <div class="col-md-6" style="line-height: 35px;">
                            {{ $celebrity->image }}
                        </div>
                    </div>

                    <div class="row">
                        <label for="description"
                               class="col-md-4 col-form-label text-md-end text-start"><strong>Description:</strong></label>
                        <div class="col-md-6" style="line-height: 35px;">
                            {{ $celebrity->description }}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop