@extends('base')

@section('title')
    Home
@endsection

@section('content')
    <h1>Home</h1>
    <p>
        @php
            dump($data);
        @endphp
    </p>
@endsection