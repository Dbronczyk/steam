@extends('layout')

@section('title', 'Wiadomości')

@section('content')
    <h1>Wiadomości!</h1>

    @if (count($conversation) == 0)
        <div class="col-md-12">
            <p>Nie masz nowych wiadomości.</p>
        </div>
    @else

        <div class="row">
            <div class="col-md-4">
                @foreach ($conversation as $c)
                    @if ($c->user1 == Auth::user()->id)
                        <div class="media link me med">
                            <a href="{{URL::route('show-message', array($c->key))}}"></a>

                            <div class="media-left">
                                {{--<a href="{{URL::route('show-profil', array($c->member2->id))}}">--}}
                                <a href="#">
                                    <img class="media-object" src="{{$c->member2->avatar}}"
                                         alt="{{$c->member2->username}}" height="60">
                                </a>
                            </div>
                            <div class="media-body">
                                <p class="pull-right">
                                    <small class="text-muted">{{ time_elapsed($c->message->first()->date) }}</small>
                                </p>
                                <h4 class="media-heading">{{$c->member2->username}}</h4>

                                @if ($c->message->last()->senderID == Auth::user()->id)
                                    <p class="text-muted">
                                        Ty: {{ str_limit($c->message->last()->message, $limit = 60, $end = '...') }}</p>
                                @elseif ($c->message->last()->senderID == $c->user1)
                                    @if ($c->message->last()->read1 == 0)
                                        <p class="text-muted">{{ str_limit($c->message->last()->message, $limit = 60, $end = '...') }}</p>
                                    @elseif($c->message->last()->read1 == 1)
                                        <p>
                                            <strong>{{ str_limit($c->message->last()->message, $limit = 60, $end = '...') }}</strong>
                                        </p>
                                    @endif
                                @elseif ($c->message->last()->senderID == $c->user2)
                                    @if ($c->message->last()->read2 == 0)
                                        <p class="text-muted">{{ str_limit($c->message->last()->message, $limit = 60, $end = '...') }}</p>
                                    @elseif($c->message->last()->read2 == 1)
                                        <p>
                                            <strong>{{ str_limit($c->message->last()->message, $limit = 60, $end = '...') }}</strong>
                                        </p>
                                    @endif
                                @endif
                            </div>
                        </div>


                    @elseif ($c->user2 == Auth::user()->id)
                        <div class="media link me med">
                            <a href="{{URL::route('show-message', array($c->key))}}"></a>

                            <div class="media-left">
                                <a href="#">
                                    <img class="media-object" src="{{$c->member1->avatar}}"
                                         alt="{{$c->member1->username}}" height="60">
                                </a>
                            </div>
                            <div class="media-body">
                                <p class="pull-right">
                                    <small class="text-muted">{{ time_elapsed($c->message->first()->date) }}</small>
                                </p>
                                <h4 class="media-heading">{{$c->member1->username}}</h4>

                                @if ($c->message->last()->senderID == Auth::user()->id)
                                    <p class="text-muted">
                                        Ty: {{ str_limit($c->message->last()->message, $limit = 60, $end = '...') }}
                                    </p>
                                @elseif ($c->message->last()->senderID == $c->user1)
                                    @if ($c->message->last()->read1 == 0)
                                        <p class="text-muted">{{ str_limit($c->message->last()->message, $limit = 60, $end = '...') }}</p>
                                    @elseif($c->message->last()->read1 == 1)
                                        <p>
                                            <strong>{{ str_limit($c->message->last()->message, $limit = 60, $end = '...') }}</strong>
                                        </p>
                                    @endif
                                @elseif ($c->message->last()->senderID == $c->user2)
                                    @if ($c->message->last()->read2 == 0)
                                        tutaj
                                        <p class="text-muted">{{ str_limit($c->message->last()->message, $limit = 60, $end = '...') }}</p>
                                    @elseif($c->message->last()->read2 == 1)
                                        <p>
                                            <strong>{{ str_limit($c->message->last()->message, $limit = 60, $end = '...') }}</strong>
                                        </p>
                                    @endif
                                @endif
                            </div>
                        </div>

                    @endif

                @endforeach
            </div>

            <div class="col-md-5">

                <div class="col-md-12 pre-scrollable" id="scroll">
                    @foreach ($msg as $m)

                        @if($m->senderID == Auth::user()->id)

                            <div class="row">
                                <div class="col-md-12">
                                    <div class="col-md-10">

                                        <div class="well well-sm">{{$m->message}}</div>
                                    </div>

                                    <div class="col-md-2">
                                        @if (Auth::user()->id == $m->conversation->member1->id)
                                            <img class="" src="{{$m->conversation->member1->avatar}}"
                                                 alt="{{$m->conversation->member1->username}}" height="50">

                                        @else
                                            <img class="media-object" src="{{$m->conversation->member2->avatar}}"
                                                 alt="{{$m->conversation->member2->username}}" height="50">
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <small class="pull-left text-muted">{{ time_elapsed($m->date) }}</small>
                            <hr>
                        @else

                            <div class="row">
                                <div class="col-md-12">
                                    <div class="col-md-2">
                                        @if (Auth::user()->id == $m->conversation->member1->id)
                                            <img class="" src="{{$m->conversation->member2->avatar}}"
                                                 alt="{{$m->conversation->member2->username}}" height="50">
                                        @else
                                            <img class="media-object" src="{{$m->conversation->member1->avatar}}"
                                                 alt="{{$m->conversation->member1->username}}" height="50">
                                        @endif
                                    </div>

                                    <div class="col-md-10">
                                        <div class="well well-sm">{{$m->message}}</div>
                                    </div>

                                </div>
                            </div>
                            <small class="pull-right text-muted">{{ time_elapsed($m->date) }}</small>
                            <hr>
                        @endif
                    @endforeach
                </div>

                <div class="col-md-12" style="margin-top: 15px;">

                    {!! Form::open(array('url' => 'message/save', 'id' => 'form')) !!}

                    @if (Auth::user()->id == $m->conversation->member1->id)
                        {{ Form::hidden('userID', $m->conversation->member2->id, array('id' => 'userID', 'value' => $m->conversation->member2->id)) }}
                    @else
                        {{ Form::hidden('userID', $m->conversation->member1->id, array('id' => 'userID', 'value' => $m->conversation->member1->id)) }}

                    @endif
                    {{ Form::textarea('message', null, ['class' => 'form-control', 'size' => '30x4', 'required' => 'required']) }}
                    <button type="submit" class="btn btn-default">Wyślij</button>
                    {!! Form::close() !!}
                </div>
            </div>
        </div>

    @endif

@stop

@section('script')
    <script>
        $(document).ready(function () {
            $('#scroll').animate({
                scrollTop: $('#scroll')[0].scrollHeight
            }, 500);
        });
    </script>

    <script type="text/javascript">
        $('#form textarea').keydown(function (e) {
            var text = $('#form textarea').val();
            text = text.replace(/(\r\n|\n|\r)/gm, "");
            if (e.keyCode == 13 && text.length > 0) {
                $('#form').submit();
            }
        });
    </script>

    <script>
        $(".link").click(function () {
            var url = $(this).find("a").attr("href");
            window.location = url;
        });
    </script>

@stop