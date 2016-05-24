@extends('layout')

@section('title', 'Hungry Fingers')

@section('css')
    <link href="{{ URL::asset('ui/jquery-ui.min.css') }}" rel="stylesheet">
    <link href="{{ URL::asset('easy-autocomplete/easy-autocomplete.css') }}" rel="stylesheet">
@stop

@section('content')

    <div class="row">
        <div class="col-xs-6 col-md-6 col-md-offset-3">
            @if (Auth::guest())
                <div class="panel panel-default">
                    <div class="panel-heading">Zaloguj się</div>
                    <div class="panel-body">
                        Aby zobaczyć coś więcej, będziesz musiał się <a href="steam">zalogować</a>.
                    </div>
                </div>

            @else

                @if (Auth::user()->role == 0)
                    <div class="panel panel-default">
                        <div class="panel-heading">Witaj, {{ Auth::user()->username  }}!</div>
                        <div class="panel-body">
                            Twoje konto nie zostało jeszcze zaakceptowane.
                        </div>
                    </div>

                    @if (empty(Auth::user()->email))
                        <p>Czekając na akceptację swojego konta, uzupełnij poniższe dane:</p>
                        {!! Form::open(array('url' => 'user/save', 'id' => 'form', 'class' => '')) !!}
                        <div class="form-group col-md-6">
                            {{ Form::label('email', 'Adres E-mail:') }}
                            {{ Form::text('email', null, array('class' => 'form-control', 'type'=>'email', 'placeholder'=>'Email')) }}
                        </div>

                        <div class="form-group col-md-12">
                            <button type="submit" class="btn btn-default">Zapisz</button>
                        </div>
                        {!! Form::close() !!}

                    @endif

                @endif



            @endif
        </div>
    </div>

    @if (!Auth::guest() && (Auth::user()->role == 1 || Auth::user()->role == 10))

        <div class="row">
            <div class="col-md-6 col-lg-offset-3" style="margin-top: 20px; margin-bottom: 20px;">
                <input type="text" class="form-control show" placeholder="Wyszukaj grę">
                <input type="hidden" class="name" id="name">
                <input type="hidden" class="hidden" id="appid">
            </div>
        </div>

        <div class="row alt">
            <h2 class="pull-left">Najnowsze oferty</h2>
        </div>
        <div class="row">
            @foreach ($sale as $s)
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
                            <p>Sprzedający <strong><a
                                            href="{{URL::route('show-profil', array($s->user->steamid))}}">{{$s->user->username}}</a></strong>
                                (

                                @if (empty($s->user->score->score))
                                    <span data-toggle="tooltip" data-placement="top"
                                          title="Ten użytkownik nie ma jeszcze opinii">0</span>
                                @else
                                    <span data-toggle="tooltip" data-placement="top"
                                          title="Punkty">{{$s->user->score->score}}</span>
                                @endif

                                )</p>

                            <p>{{ time_elapsed($s->date) }}</p>
                        </div>
                        <div class="col-md-3 text-right prc"><p>{{$s->price}} zł</p></div>

                    </div>

                    <div class="media-right">

                        @if ($s->user->id == Auth::user()->id)
                            <a href="#" class="btn btn-primary disabled buy">Kup
                            </a>
                        @else
                            <a href="{{URL::route('buy', array($s->id))}}" class="btn btn-primary buy">Kup
                            </a>
                        @endif

                    </div>
                </div>
            @endforeach

            {{ $sale->render() }}

        </div>
    @endif

@stop

@section('script')

    <script src="{{ URL::asset('ui/jquery-ui.min.js') }}"></script>
    <script src="{{ URL::asset('easy-autocomplete/easy-autocomplete.js') }}"></script>

    <script>

        $("body").on("click", ".buuy", function (e) {
            var id = $(this).parent("div").parent("div").attr("id");

//            $(this).parent("div").parent("div").slideUp("fast", "linear", function () {
//                $(this).remove();
//            });
            var parent = $(this).parent("div");
            $(parent).children('.buy').remove();
            $(parent).append('<a href="{{URL::route('purchases')}}" class="btn btn-success buy" data-toggle="tooltip" data-placement="top"' +
                    ' title="Przejdź do zakładki kupione.">Kupione!</a>').tooltip();

//            $(".alt").append('<div class="alert alert-success text-center myAlert" style="width: 500px;  margin: 0px auto;">' +
//                    '<strong>Kupione!</strong> Swoje zakupy zobaczysz w zakladce Kupione.' +
//                    '</div>');
//
//            $('.myAlert').delay(2000).each(function (index) {
//                $(this).queue(
//                        function () {
//                            $(this).hide();
//                            $(this).remove();
//                        }
//                );
//            });


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


    <script>
        var options = {
            url: function (phrase) {
                return "http://steam.dbronczyk.pl/json/" + phrase;
            },
            getValue: function (element) {
                return element.name;
            },
            requestDelay: 300,
            template: {
                type: "iconLeft",
                fields: {
                    iconSrc: function (element) {
                        return "http://cdn.akamai.steamstatic.com/steam/apps/" + element.appid + "/header.jpg";
                    },
                },
            },
            list: {
                match: {
                    enabled: true
                },
                maxNumberOfElements: 6,
                onClickEvent: function () {
                    var appid = $(".show").getSelectedItemData().appid;
                    var name = $(".show").getSelectedItemData().name;
                    //var slug = name.replaceAll(" ", "+");
                    name = name.toLowerCase();
                    var slug = name.replace(/\:/g, '');
                    var slug = name.replace(/\-/g, '');
                    var slug = name.replace(/\ /g, '+');
                    //console.log(slug);

                    var url = 'http://steam.dbronczyk.pl/search/' + appid + '/' + slug;
                    window.location = url;
                }

            },

        };

        $('.show').easyAutocomplete(options);


        //        $('.show').keydown(function (e) {
        //            //var text = $('#form textarea').val();
        //            //text = text.replace(/(\r\n|\n|\r)/gm, "");
        //            if (e.keyCode == 13) {
        //                console.log('enter');
        //            }
        //        });


    </script>

@stop