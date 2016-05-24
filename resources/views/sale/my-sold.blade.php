@extends('layout')

@section('title', 'Moje sprzedane gry')

@section('css')
@stop


@section('content')
    <h1>Sprzedane</h1>

    @if (count($orders) == 0)
        <div class="alert alert-warning" role="alert"><strong>Brak danych.</strong> Brak sprzedanych gier.</div>
    @else

        @foreach ($orders as $index => $order)
            <div class="media med" id="{{ $order->id }}">
                <div class="media-left">
                    <a href="#">
                        <img class="media-object"
                             src="http://cdn.akamai.steamstatic.com/steam/apps/{{ $order->sale->appid }}/header.jpg"
                             alt="{{ $order->sale->game->name }}" height="60">
                    </a>
                </div>
                <div class="media-body">
                    <div class="col-md-4">
                        <h4 class="media-heading">{{ $order->sale->game->name }}</h4>

                        <p class="zero">
                            <small>{{$order->sale->desc}}</small>
                        </p>
                        <p class="zero"><strong>{{$order->sale->price}} zł</strong></p>
                    </div>
                    <div class="col-md-6">
                        <div class="col-md-6">
                            <p>Kupujący <a
                                        href="{{URL::route('show-profil', array($order->buyer->id))}}">{{$order->buyer->username}}</a></h4>
                            </p>

                            <p>Data sprzedaży: <strong><span
                                            data-toggle="tooltip"
                                            data-trigger="hover"
                                            data-placement="top" data-html="true"
                                            data-title="{{gmdate("Y-m-d H:i:s", $order->date)}}">
                                    {{gmdate("Y-m-d", $order->date)}}</span></strong>
                            </p>
                        </div>


                        <div class="col-md-6">
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
        @endforeach

        {{ $orders->render() }}

    @endif

@stop

@section('script')
    <script>
        $(document).ready(function () {
            $('[data-toggle="tooltip"]').tooltip();
        });
    </script>
@stop