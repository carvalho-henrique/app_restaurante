@extends('layouts.app')

@section('content')
@auth
    <home-component login="y"></home-component>
@else 
    <home-component login="n"></home-component>
@endauth
@endsection
