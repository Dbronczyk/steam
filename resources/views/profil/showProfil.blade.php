@extends('layout')

@section('title', $user->username)

@section('css')

@stop


@section('content')

    <div class="row">
        <div class="col-md-3 text-center">
            <img src="{{$user->avatar}}" alt="{{$user->username}}" height="220">
        </div>
        <div class="col-md-9">
            <div class="col-md-6">
                <h2>{{$user->username}}

                    @if($user->role == 0)
                        <small>brak aktywacji</small>
                    @elseif($user->role == 1)
                        <small>Użytkownik</small>
                    @elseif($user->role == 10)
                        <small>Administrator</small>
                    @endif

                </h2>

                <p><strong>Imię:</strong> {{$user->name}}</p>

                <p><strong>Zarejestrowany:</strong> {{strtok($user->created_at, " ")}}</p>

                <p><strong>Kraj:</strong> {{$user->countryCode}}</p>
            </div>
            <div class="col-md-6">
                <h2>Opinie</h2>
                @if (count($score) == 0)
                    <p><strong>Ilość punktów:</strong> Brak.</p>
                @else
                    <p><strong>Ilość punktów:</strong> {{$score->score}}</p>
                @endif


                @foreach($opinions as $opinion)

                    <p><i class="fa fa-btn fa-user" data-tooltip="tooltip" data-placement="top"
                          title="{{$opinion->rev->username}}"></i> <span data-tooltip="tooltip" data-placement="top"
                                                                         title="{{$opinion->opinion}}">{{ str_limit($opinion->opinion, $limit = 45, $end = '...') }}</span>

                        @if($opinion->status == 1)
                            <span class="label label-success pull-right" data-tooltip="tooltip" data-placement="top"
                                  title="
                                  @if($opinion->what == 1)
                                          Sprzedaż
                                  @else
                                          Kupno
                                      @endif
                                          ">Pozytywny</span>
                        @else
                            <span class="label label-danger pull-right" data-tooltip="tooltip" data-placement="top"
                                  title="
                                  @if($opinion->what == 1)
                                          Sprzedaż
                                  @else
                                          Kupno
                                      @endif
                                          ">Negatywny</span>
                        @endif


                    </p>

                @endforeach

            </div>
        </div>
    </div>
    <hr>
    <div class="row">
        <div class="col-md-3 text-center">

            <a href="{{$user->profileURL}}" target="_blank" class="btn btn-default soc"
               data-tooltip="tooltip" data-placement="top" title="Profil Steam"><i
                        class="fa fa-steam" aria-hidden="true"></i></a>

            @if ($user->id == Auth::user()->id)
                <a href="#" class="btn btn-default soc" data-target=".bs-example-modal-sm"
                   data-tooltip="tooltip" data-placement="top" title="Sam do siebie?"><i
                            class="fa fa-envelope" aria-hidden="true"></i></a>
            @else
                <a href="#" class="btn btn-default soc" data-toggle="modal" data-target="#pw"
                   data-tooltip="tooltip" data-placement="top" title="Wyślij PW"><i
                            class="fa fa-envelope" aria-hidden="true"></i></a>
            @endif


            <a href="{{URL::route('opinions', array($user->steamid))}}" class="btn btn-default soc" data-tooltip="tooltip"
               data-placement="top" title="Opinie"><i
                        class="fa fa-check"
                        aria-hidden="true"></i></a>

            <a href="#" class="btn btn-default soc" data-tooltip="tooltip" data-toggle="modal" data-target="#report"
               data-placement="top" title="Zgłoś"><i
                        class="fa fa-exclamation" aria-hidden="true"></i></a>
        </div>
    </div>

    <hr>

    <div class="row">
        <div class="col-md-12">
            @if (count($sale) == 0)
                <div class="col-md-12">
                    <p>Ten użytkownik nic nie sprzedaje.</p>
                </div>
            @else
                <h2>Aktualna oferta użytkownika {{$user->username}}</h2>
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
                                <p>{{ time_elapsed($s->date) }}</p>
                            </div>
                            <div class="col-md-3 text-right prc"><p>{{$s->price}} zł</p></div>
                        </div>

                        <div class="media-right">
                            <button type="button" class="btn btn-primary buy" data-toggle="tooltip" data-placement="top"
                                    title="Instant buy {{ $s->game->name }}">Kup
                            </button>
                        </div>
                    </div>
                @endforeach

                {{ $sale->render() }}
            @endif
        </div>
    </div>


    <div class="modal fade bs-example-modal-sm" id="pw" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel">
        <div class="modal-dialog modal-sm">
            <div class="modal-content">
                <div class="modal-content">
                    {!! Form::open(array('url' => 'message/save')) !!}
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                    aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title" id="myModalLabel">Wiadomość do {{$user->username}}</h4>
                    </div>
                    <div class="modal-body">

                        {{ Form::hidden('userID', $user->id, array('id' => 'userID', 'value' => $user->id)) }}
                        {{ Form::textarea('message', null, ['class' => 'form-control', 'size' => '30x4']) }}

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Zamknij</button>
                        <button type="submit" class="btn btn-primary">Wyślij</button>
                    </div>
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>




    <div class="modal fade bs-example-modal-sm" id="report" tabindex="-1" role="dialog"
         aria-labelledby="mySmallModalLabel">
        <div class="modal-dialog modal-sm">
            <div class="modal-content">
                <div class="modal-content">
                    {!! Form::open(array('url' => 'report/save')) !!}
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                    aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title" id="myModalLabel">Zgłoszenie na {{$user->username}}</h4>
                    </div>
                    <div class="modal-body">

                        {{ Form::hidden('userID', $user->id, array('id' => 'userID', 'value' => $user->id)) }}
                        {{ Form::label('reason', 'Powód zgłoszenia') }}
                        {{ Form::textarea('reason', null, ['class' => 'form-control', 'size' => '30x4']) }}

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Zamknij</button>
                        <button type="submit" class="btn btn-primary">Wyślij</button>
                    </div>
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>




@stop

@section('script')
    <script>
        $('[data-tooltip="tooltip"]').tooltip();
    </script>


    <script>
        $("body").on("click", ".buy", function (e) {
            var id = $(this).parent("div").parent("div").attr("id");

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

    </script>

@stop