@extends('layout')

@section('title', 'Steam')

@section('content')
    <h1>Kupione</h1>

    @if (count($orders) == 0)
        <div class="alert alert-warning" role="alert"><strong>Brak danych.</strong> Brak zakupów.</div>
    @else

        @foreach ($orders as $index => $order)
            <div class="media med" id="{{ $order->id }}">
                <div class="media-left">
                    <a href="#">
                        <img class="media-object"
                             src="http://cdn.akamai.steamstatic.com/steam/apps/{{$order->sale->game->appid}}/header.jpg"
                             alt="{{$order->sale->game->name}}" height="60">
                    </a>
                </div>
                <div class="media-body">
                    <div class="col-md-4">
                        <h4 class="media-heading">{{$order->sale->game->name}}</h4>

                        <p class="zero">
                            <small>{{$order->sale->game->desc}}</small>
                        </p>
                        <p class="zero"><strong>{{$order->sale->price}} zł</strong></p>
                    </div>
                    <div class="col-md-6">
                        <div class="col-md-6">

                            <p>Sprzedający <a
                                        href="{{URL::route('show-profil', array($order->seller->id))}}">{{$order->seller->username}}</a></h4>
                            </p>

                            <p>Data kupna: <strong><span
                                            data-toggle="tooltip"
                                            data-trigger="hover"
                                            data-placement="top" data-html="true"
                                            data-title="{{gmdate("Y-m-d H:i:s", $order->date)}}">
                                    {{gmdate("Y-m-d", $order->date)}}</span></strong>
                            </p>
                        </div>


                        <div class="col-md-6 ">
                            @if ($order->remove != 0)
                                @if($order->remove == Auth::user()->id)
                                    <p>
                                        <button type="button" class="btn btn-default btn-xs pw" data-toggle="modal"
                                                data-target="#myModal{{ $index+1 }}"
                                                title="Wyślij PW, aby uzgodnić warunki płatności."
                                                data-tooltip="tooltip"
                                                data-placement="top" rel="tooltip">Wyślij PW
                                        </button>
                                    </p>

                                    <p>
                                    <span class="label label-warning" rel="tooltip"
                                          data-toggle="tooltip" data-placement="top"
                                          title="Twoje zgłoszenie czeka na zaakceptowanie.">Wysłano prośbę o usunięcie.</span>
                                    </p>
                                @else
                                    <p>
                                        <button type="button" class="btn btn-default btn-xs pw" data-toggle="modal"
                                                data-target="#myModal{{ $index+1 }}"
                                                title="Wyślij PW, aby uzgodnić warunki płatności."
                                                data-tooltip="tooltip"
                                                data-placement="top" rel="tooltip">Wyślij PW
                                        </button>

                                        <a href="{{URL::route('add-opinion', array($order->seller->id, $order->sale->id))}}"
                                           rel="tooltip" data-toggle="tooltip" data-placement="top"
                                           title="Wystaw opinię po zakończeniu transakcji."
                                           class="btn btn-default btn-xs opinia">Napisz
                                            opinię</a>

                                        <a href="{{URL::route('remove-order', array($order->id))}}" rel="tooltip"
                                           data-toggle="tooltip" data-placement="top"
                                           title="To będzie wymagało obopulnej zgody."
                                           class="btn btn-default btn-xs usun">Usuń
                                        </a>
                                    </p>
                                    <p>
                                     <span class="label label-info" rel="tooltip"
                                           data-toggle="tooltip" data-placement="top"
                                           title="Użytkownik {{$order->remover->username}} chce unieważnić to zamówienie. Usuń, aby unieważnić.">
                                         Użytkownik {{ str_limit($order->remover->username." chce unieważnić to zamówienie.", $limit = 37, $end = '...') }}
                                     </span>
                                    </p>
                                @endif
                            @else
                                <p>
                                    <button type="button" class="btn btn-default btn-xs pw" data-toggle="modal"
                                            data-target="#myModal{{ $index+1 }}"
                                            title="Wyślij PW, aby uzgodnić warunki płatności." data-tooltip="tooltip"
                                            data-placement="top" rel="tooltip">Wyślij PW
                                    </button>

                                    <a href="{{URL::route('add-opinion', array($order->seller->id, $order->sale->id))}}"
                                       rel="tooltip" data-toggle="tooltip" data-placement="top"
                                       title="Wystaw opinię po zakończeniu transakcji."
                                       class="btn btn-default btn-xs opinia">Napisz
                                        opinię</a>

                                    <a href="{{URL::route('remove-order', array($order->id))}}" rel="tooltip"
                                       data-toggle="tooltip" data-placement="top"
                                       title="To będzie wymagało obopulnej zgody." class="btn btn-default btn-xs usun">Usuń
                                    </a>

                                </p>
                            @endif


                        </div>


                    </div>
                    <div class="col-md-2 text-right prc"><p>{{$order->sale->price}} zł</p></div>

                </div>

            </div>





            {{--<div class="modal fade bs-example-modal-sm" tabindex="-1" role="dialog" id="mySmallModalLabel{{ $index+1 }}" aria-labelledby="mySmallModalLabel{{ $index+1 }}">--}}
            {{--<div class="modal-dialog modal-sm">--}}
            {{--<div class="modal-content">--}}
            {{--<div class="modal-content">--}}
            {{--{!! Form::open(array('url' => 'message/save')) !!}--}}
            {{--<div class="modal-header">--}}
            {{--<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span--}}
            {{--aria-hidden="true">&times;</span></button>--}}
            {{--<h4 class="modal-title" id="myModalLabel">Wiadomość do {{$order->seller->username}}</h4>--}}
            {{--</div>--}}
            {{--<div class="modal-body">--}}

            {{--{{ Form::hidden('userID', $order->seller->id, array('id' => 'userID', 'value' => $order->seller->id)) }}--}}
            {{--{{ Form::textarea('message', null, ['class' => 'form-control', 'size' => '30x4']) }}--}}

            {{--</div>--}}
            {{--<div class="modal-footer">--}}
            {{--<button type="button" class="btn btn-default" data-dismiss="modal">Zamknij</button>--}}
            {{--<button type="submit" class="btn btn-primary">Wyślij</button>--}}
            {{--</div>--}}
            {{--{!! Form::close() !!}--}}
            {{--</div>--}}
            {{--</div>--}}
            {{--</div>--}}
            {{--</div>--}}


            <div class="modal fade" id="myModal{{ $index+1 }}" tabindex="-1" role="dialog"
                 aria-labelledby="myModalLabel">
                <div class="modal-dialog modal-sm">
                    <div class="modal-content">
                        <div class="modal-content">
                            {!! Form::open(array('url' => 'message/save')) !!}
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                            aria-hidden="true">&times;</span></button>
                                <h4 class="modal-title" id="myModalLabel">Wiadomość do {{$order->seller->username}}</h4>
                            </div>
                            <div class="modal-body">

                                {{ Form::hidden('userID', $order->seller->id, array('id' => 'userID', 'value' => $order->seller->id)) }}
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




        @endforeach

    @endif


    {{--<!-- Button trigger modal -->--}}
    {{--<button type="button" class="btn btn-primary btn-lg" data-toggle="modal" data-target="#myModal1">--}}
    {{--Launch demo modal--}}
    {{--</button>--}}

    {{--<!-- Modal -->--}}
    {{--<div class="modal fade" id="myModal1" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">--}}
    {{--<div class="modal-dialog" role="document">--}}
    {{--<div class="modal-content">--}}
    {{--<div class="modal-header">--}}
    {{--<button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>--}}
    {{--<h4 class="modal-title" id="myModalLabel">Modal title</h4>--}}
    {{--</div>--}}
    {{--<div class="modal-body">--}}
    {{--...--}}
    {{--</div>--}}
    {{--<div class="modal-footer">--}}
    {{--<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>--}}
    {{--<button type="button" class="btn btn-primary">Save changes</button>--}}
    {{--</div>--}}
    {{--</div>--}}
    {{--</div>--}}
    {{--</div>--}}


@stop

@section('script')
    <script>
        $('[rel="tooltip"]').tooltip();

        $(".pw").hover(
                function () {
                    //$(this).parent('div').find('.info').text("Wyślij wiadomość prywatną");
                    var i = $(this).prev('p').next('p').text("asd");
                    console.log(i);
                }, function () {
                    $('.info').text("");
                }
        );

        $(function () {
            $('[data-toggle="tooltip"]').tooltip()
        })

    </script>


@stop
