@extends('layouts.default')
@section('content')
    @php
        use App\Models\Celebrity;use App\Models\Movie;
               $celebrities = Celebrity::all();
               $movies = Movie::all();
    @endphp
    @include('celebrities.index')
@stop