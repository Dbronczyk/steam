@extends('layout')

@section('title', 'Stwórz nową ofertę')

@section('content')

    <div class="col-xs-6 col-md-6 col-md-offset-3">
        @if ($ok == 1)
            <div class="panel panel-default">
                <div class="panel-heading">Brak autoryzacji</div>
                <div class="panel-body">
                    Wygląda na to, że Twoje konto nie zostało jeszcze aktywowane. Pracujemy nad tym.
                </div>
            </div>
        @endif

        @if ($ok == 2)
            <div class="panel panel-default">
                <div class="panel-heading">Wszystko jest w porządku!</div>
                <div class="panel-body">
                    Może <a href="#">kupiłbyś</a> coś albo <a href="#">sprzedał</a>?
                </div>
            </div>
        @endif
    </div>

@stop