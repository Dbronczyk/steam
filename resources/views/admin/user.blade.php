@extends('admin')

@section('title', $user->username.' | Edycja | Hungry Fingers')

@section('content')

    <div class="col-md-8">

        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title">Szczegóły konta użytkownika <strong>{{$user->username}}</strong></h3>
            </div>
            <div class="panel-body">
                {!! Form::open(array('url' => 'user/update/'.$user->steamid, 'id' => 'form')) !!}
                <div class="form-group">
                    <label for="name">Nazwa</label>
                    <input type="text" class="form-control" id="name" name="name" placeholder="Name"
                           value="{{$user->name}}">
                </div>
                <div class="form-group">
                    <label for="steam">Nazwa Steam</label>
                    <input type="text" class="form-control" id="steam" name="steam" placeholder="Username"
                           value="{{$user->username}}">
                </div>

                <div class="form-group">

                    @if (empty($user->score->score))
                        <label for="score">Ilość punktów</label>
                        <input type="text" class="form-control" id="score" name="score" placeholder="score"
                               value="0">
                    @else
                        <label for="score">Ilość punktów</label>
                        <input type="text" class="form-control" id="score" name="score" placeholder="score"
                               value="{{$user->score->score}}">
                    @endif


                </div>

                <div class="form-group">
                    <label for="email">Adres email</label>
                    <input type="text" class="form-control" name="email" id="email" placeholder="Email"
                           value="{{$user->email}}">
                </div>

                <div class="form-group">
                    <label for="status">Status</label>
                    <select class="form-control" id="status" name="status">
                        <option value="0" {{ ($user->role == 0) ? "selected" : '' }} >Brak aktywacji</option>
                        <option value="1" {{ ($user->role == 1) ? "selected" : '' }}>Użytkownik</option>
                        <option value="9" {{ ($user->role == 9) ? "selected" : '' }}>Ban</option>
                        <option value="10" {{ ($user->role == 10) ? "selected" : '' }}>Admin</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="created">Data utworzenia konta</label>
                    <input type="text" class="form-control" id="created" name="created" placeholder="steam"
                           value="{{$user->created_at}}">
                </div>

                <button type="submit" class="btn btn-default">Zapisz</button>
                {!! Form::close() !!}
            </div>
        </div>
    </div>
@stop