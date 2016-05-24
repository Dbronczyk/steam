@extends('layout')

@section('title', 'Steam')

@section('content')
    <h1>Witaj na swoim profilu {{ Auth::user()->username }}!</h1>
@stop