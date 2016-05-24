@extends('layout')

@section('title', 'Steam')

@section('content')

    @if (count($sale) == 0)
        <div class="alert alert-warning" role="alert"><strong>Brak ofert.</strong> Aktualnie brak ofert dla tego
            produktu.
        </div>
    @else

        <div class="row">
            <div class="col-md-4">
                <img class="media-object"
                     src="http://cdn.akamai.steamstatic.com/steam/apps/{{ $sale->appid }}/header.jpg"
                     alt="{{ $sale->appid }}" height="170">
            </div>

            <div class="col-md-8">
                <p class="pull-right">
                    <small><strong>Dodano</strong> {{ time_elapsed($sale->date) }}</small>
                </p>
                <h1>{{$sale->game->name}}</h1>

                <p>{{$sale->desc}}</p>

                <p class="pull-right">
                    <button type="button" class="btn btn-primary buy" data-toggle="tooltip" data-placement="top"
                            title="Instant buy {{$sale->game->name}}">Kup
                    </button>
                </p>

                <p class="prc">{{$sale->price}} zł</p>

                <p class="pull-right">Sprzedający: <strong><a
                                href="{{URL::route('show-profil', array($sale->user->id))}}">{{$sale->user->username}}</a> ({{$sale->user->score->score}})</strong>
                </p>

            </div>
        </div>

        <hr>


        <div class="row">


            @if (count($games) == 0)
                <div class="col-md-12">
                    <p>Aktualnie brak innych ofert</p>
                </div>
            @else
                @foreach ($games as $s)
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
                                <h4 class="media-heading"><a
                                            href="{{URL::route('show', array($s->id))}}">{{ $s->game->name }}</a></h4>

                                <p class="zero">
                                    <small>{{$s->desc}}</small>
                                </p>
                                <p class="zero"><strong>{{$s->price}} zł</strong></p>
                            </div>


                            <div class="col-md-4">

                                <p>sprzedający
                                    <strong><a href="{{URL::route('show-profil', array($s->user->id))}}">{{$s->user->username}}</a> ({{$s->user->score->score}})</strong>
                                </p>

                                <p>

                                <p>{{ time_elapsed($s->date) }}</p></p>

                            </div>
                            <div class="col-md-3 text-right prc"><p>{{$s->price}} zł</p></div>

                        </div>


                        <div class="media-right">
                            <button type="button" class="btn btn-primary buy">Kup</button>
                        </div>
                    </div>
                @endforeach
            @endif
        </div>

    @endif

@stop

@section('script')
    <script>
        $("body").on("click", ".buy", function (e) {
            var id = $(this).parent("div").parent("div").attr("id");

            console.log(id);

            $(this).parent("div").parent("div").slideUp("fast", "linear", function () {
                $(this).remove();
            });

            $(".alt").append('<div class="alert alert-success text-center myAlert" style="width: 500px;  margin: 0px auto;">' +
                    '<strong>Kupione!</strong> Swoje zakupy zobaczysz w zakladce Kupione.' +
                    '</div>');

            $('.myAlert').delay(2000).each(function (index) {
                $(this).queue(
                        function () {
                            $(this).hide();
                            $(this).remove();
                        }
                );
            });


            $.ajax({
                url: '/buy/' + id,
                data: {"_token": "{{ csrf_token() }}"},
                type: 'GET',
                success: function (result) {
                }
            });
        });

        $(function () {
            $('[data-toggle="tooltip"]').tooltip()
        })
    </script>

@stop