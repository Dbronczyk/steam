@extends('layout')

@section('title', 'Napisz opinię')

@section('content')


    <div class="col-md-12">
        <h1>Opinia o transakcji z użytkownikem {{$user->username}}</h1>
        <hr>
        <p>Gra: <strong>{{$sale->game->name}}</strong>.</p>

        <p>Srzedający: <strong><a
                        href="{{URL::route('show-profil', array($sale->order->seller->id))}}">{{$sale->order->seller->username}}</a></strong>
        </p>

        <p>Kupujący: <strong><a
                        href="{{URL::route('show-profil', array($sale->order->buyer->id))}}">{{$sale->order->buyer->username}}</a></strong>
        </p>

        <p>Data: <strong>{{gmdate("Y-m-d H:i:s", $sale->date)}}</strong></p>
    </div>


    <div class="col-md-6">
        {!! Form::open(array('url' => 'opinions/save', 'id' => 'form')) !!}

        <div class="row">
            <div class="col-md-6 form-group">
                {!! Form::label('status', 'Transakcja przebiegła') !!}
                {!! Form::select('status', array('1' => 'Pozytywnie +1 punkt', '0' => 'Negatywnie -5 punktów'), null, array('class' => 'form-control', 'id' => 'message')) !!}
            </div>
        </div>

        {{ Form::hidden('userID', $user->id) }}
        {{ Form::hidden('saleID', $sale->id) }}
        {{ Form::hidden('reviewer', Auth::user()->id) }}

        <div class="row">
            <div class="col-md-12 form-group">
                {!! Form::label('opinion', 'Opinia') !!}
                {{ Form::textarea('opinion','Transakcja przebiegła pomyślnie. Polecam.', ['class' => 'form-control', 'size' => '30x4', 'required' => 'required']) }}
            </div>
        </div>


        <button type="submit" class="btn btn-default">Wyślij</button>
        {!! Form::close() !!}
    </div>

@stop

@section('script')
    <script>

    </script>
@stop