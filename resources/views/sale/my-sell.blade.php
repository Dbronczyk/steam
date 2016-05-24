@extends('layout')

@section('title', 'Moje oferty')

@section('css')
@stop


@section('content')
    <h1>Moje oferty</h1>

    @foreach ($sell as $s)
        <div class="media med" id="{{ $s->id }}">
            <div class="media-left">
                <a href="#">
                    <img class="media-object"
                         src="http://cdn.akamai.steamstatic.com/steam/apps/{{ $s->appid }}/header.jpg"
                         alt="{{ $s->game->name }}" height="60">
                </a>
            </div>
            <div class="media-body">
                <div class="col-md-5">
                    <h4 class="media-heading">
                    <a href="{{URL::route('show', array($s->id))}}">{{ $s->game->name }}</a>
                    </h4>

                    <p class="zero">
                        <small>{{$s->desc}}</small>
                    </p>
                    <p class="pull-right text-muted">{{ time_elapsed($s->date) }}</p>
                    <p class="zero"><strong>{{$s->price}} zł</strong></p>
                </div>
                <div class="col-md-4">
                    <div class="col-md-2">
                        @if ($s->active === 1)
                            <button type="button" class="btn btn-success published" data-toggle="tooltip"
                                    data-placement="top"
                                    title="Opublikowany">
                                <i class="fa-1x fa fa-eye" aria-hidden="true"></i>
                            </button>
                        @elseif ($s->active === 0)
                            <button type="button" class="btn btn-danger unlisted" data-toggle="tooltip"
                                    data-placement="top"
                                    title="Nie opublikowany">
                                <i class="fa-1x fa fa-eye-slash" aria-hidden="true"></i>
                            </button>
                        @endif



                    </div>

                    {{--<div class="col-md-6 text-right"><p>Brak ofert</p></div>--}}

                </div>
                <div class="col-md-3 text-right prc"><p>{{$s->price}} zł</p></div>

            </div>


            <div class="media-right">
                <button type="button" class="btn btn-primary btn-xs editBtn">Edytuj</button>
                <button type="button" class="btn btn-danger btn-xs deleteBtn">Usuń</button>
            </div>
        </div>
    @endforeach

    {{ $sell->render() }}

@stop

@section('script')
    <script>
        $(document).ready(function () {
            $('[data-toggle="tooltip"]').tooltip();
        });
    </script>


    <script>
        $("body").on("click", ".deleteBtn", function (e) {
            var id = $(this).parent("div").parent("div").attr("id");
            $(this).parent("div").parent("div").slideUp("fast", "linear", function () {
                $(this).remove();
            });

            $.ajax({
                url: '/remove/' + id,
                data: {"_token": "{{ csrf_token() }}"},
                type: 'DELETE',
                success: function (result) {
                }
            });

            //console.log(appid);
        });
    </script>


    <script>
        $("body").on("click", ".published", function (e) {
            var id = $(this).parent("div").parent("div").parent("div").parent("div").attr("id");

            //console.log(id);
            $(this).removeClass("btn-success published");
            $(this).addClass("btn-danger unlisted");
            $(this).html('<i class="fa-1x fa fa-eye-slash" aria-hidden="true"></i>');

            $.ajax({
                url: '/update/' + id,
                data: {"_token": "{{ csrf_token() }}"},
                type: 'GET',
                success: function (result) {
                }
            });
        });
    </script>

    <script>
        $("body").on("click", ".unlisted", function (e) {
            var id = $(this).parent("div").parent("div").parent("div").parent("div").attr("id");

            //console.log(id);
            $(this).removeClass("btn-danger unlisted");
            $(this).addClass("btn-success published");
            $(this).html('<i class="fa-1x fa fa-eye-slash" aria-hidden="true"></i>');

            $.ajax({
                url: '/update/' + id,
                data: {"_token": "{{ csrf_token() }}"},
                type: 'GET',
                success: function (result) {
                }
            });
        });
    </script>



@stop