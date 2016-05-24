@extends('layout')

@section('title', 'Potwierdzenie zakupu '. $sale->game->name)

@section('css')
@stop


@section('content')


    <div class="container">

        <h1>Potwierdzenie zakupu</h1>


        <div class="col-md-4 col-xs-12">
            <img class="img-responsive"
                 src="http://cdn.akamai.steamstatic.com/steam/apps/{{ $sale->game->appid }}/header.jpg"
                 alt="{{ $sale->game->name }}" height="170">
        </div>
        <div class="col-md-8 col-xs-12">

            <p class="pull-right">
                <small><strong>Dodano</strong> {{ time_elapsed($sale->date) }}</small>
            </p>
            <h2>{{$sale->game->name}}</h2>

            <p>{{$sale->desc}}</p>

            <p class="prc">{{$sale->price}} zł</p>

            <p class="pull-right">Sprzedający: <strong><a
                            href="{{URL::route('show-profil', array($sale->user->id))}}">{{$sale->user->username}}</a>
                    ({{$sale->user->score->score}})</strong>
            </p>


        </div>

    </div>
    <hr>


    <div class="container">
        <div class="col-md-12 col-xs-12 text-right">

            <p class="">
                <strong>Klikając przycisk, potwierdzasz zakup</strong>
                <a href="{{URL::route('buy-confirm', array($sale->id))}}" class="btn btn-primary buy"
                   style="margin-left: 15px;">Kupuję</a>
            </p>
        </div>
    </div>

@stop