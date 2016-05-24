@extends('layout')

@section('title', 'Opinie użytkownika ...')

@section('content')
    {{--<h1>Opinie użytkownika {{$user->username}}</h1>--}}
    {{--<p>Punkty: {{$user->score->score}}</p>--}}

    <div class="row">
        <div class="col-md-2">
            <img src="{{$user->avatar}}" alt="{{$user->username}}" height="150">
        </div>
        <div class="col-md-9">
            <h1>{{$user->username}}</h1>
            <p>Punkty: <strong>{{$user->score->score}}</strong></p>
        </div>
    </div>

<hr>
    <h2>Wszystkie opinie</h2>



    @if (count($opinions) == 0)
        <div class="col-md-12">
            <p>Brak opini.</p>
        </div>
    @else

        <div class="row" style="margin-bottom: 10px;">
            <div class="pull-right">
                <div class="btn-group">
                    <button type="button" class="btn btn-success btn-filter" data-target="1">Pozytywne</button>
                    <button type="button" class="btn btn-danger btn-filter" data-target="0">Negatywne</button>
                    <button type="button" class="btn btn-default btn-filter" data-target="all">Wszystkie</button>
                </div>
            </div>
        </div>


        <table class="table table-hover">
            <tbody>

            @foreach($opinions as $op)

                <tr data-status="{{$op->status}}">
                    <td>

                        <div class="media">
                            <a class="media-left" href="#">
                                <img class="media-object" src="{{$op->rev->avatar}}" alt="{{$op->rev->username}}"
                                     height="50">
                            </a>

                            <div class="media-body">
                                <h4 class="media-heading"><a href="{{URL::route('show-profil', array($op->rev->id))}}">{{$op->rev->username}}</a>
                                </h4>

                                <p>{{$op->opinion}}</p>
                            </div>
                        </div>


                    </td>
                    <td>
                        @if($op->what == 1)
                            <span class="label label-info">Sprzedaż</span>
                        @else
                            <span class="label label-primary">Kupno</span>
                        @endif
                    </td>
                    <td>

                        @if($op->status == 1)
                            <span class="label label-success">Pozytywny</span>
                        @else
                            <span class="label label-danger">Negatywny</span>
                        @endif

                    </td>

                    <td>
                        {{--{{$op->date}}--}}
                        {{--{{ time_elapsed($op->date) }}--}}
                        <strong><span data-toggle="tooltip" data-placement="top"
                                      title="{{ time_elapsed($op->date) }}">{{gmdate("Y-m-d", $op->date)}}</span>
                        </strong>
                    </td>

                </tr>


            @endforeach

            </tbody>
        </table>
        </div>

    @endif


@stop

@section('script')
    <script>
        $(document).ready(function () {

            $('.btn-filter').on('click', function () {
                var $target = $(this).data('target');
                if ($target != 'all') {
                    $('.table tr').css('display', 'none');
                    $('.table tr[data-status="' + $target + '"]').fadeIn('slow');
                } else {
                    $('.table tr').css('display', 'none').fadeIn('slow');
                }
            });

        });


        $(function () {
            $('[data-toggle="tooltip"]').tooltip()
        })

    </script>
@stop