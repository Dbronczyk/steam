@extends('admin')

@section('title', 'Hungry Fingers | Panel Administracyjny')

@section('content')
<h1>Witaj w panelu administratora {{ Auth::user()->username }}! </h1>

@stop