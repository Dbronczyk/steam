@extends('admin')

@section('title', 'Hungry Fingers | Lista gier')

@section('content')
    <h1>Lista gier</h1>

    @foreach ($games as $game)
        <div class="media" id="{{ $game->appid }}">
            <div class="media-left">
                <a href="#">
                    <img class="media-object"
                         src="http://cdn.akamai.steamstatic.com/steam/apps/{{ $game->appid }}/header.jpg"
                         alt="{{ $game->name }}" height="60">
                </a>
            </div>
            <div class="media-body">
                <h4 class="media-heading">{{ $game->name }}</h4>
                <small><a href="http://store.steampowered.com/app/{{ $game->appid }}/" target="_blank">http://store.steampowered.com/app/{{ $game->appid }}</a>
                </small>
            </div>
            <div class="media-right">
                <button type="button" class="btn btn-primary btn-xs editBtn">Edytuj</button>
                <button type="button" class="btn btn-danger btn-xs deleteBtn">Usuń</button>
            </div>
        </div>
    @endforeach

    {{ $games->render() }}

@stop

@section('script')
    <script>
        $("body").on("click", ".deleteBtn", function (e) {
            var appid = $(this).parent("div").parent("div").attr("id");
            $(this).parent("div").parent("div").slideUp("fast", "linear", function () {
                $(this).remove();
            });

            $.ajax({
                url: '/admin/games/remove/' + appid,
                data: {"_token": "{{ csrf_token() }}"},
                type: 'DELETE',
                success: function (result) {
                    //console.log(result);
                }
            });

            //console.log(appid);
        });
    </script>
@stop