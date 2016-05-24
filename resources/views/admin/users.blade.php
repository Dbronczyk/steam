@extends('admin')

@section('title', 'Lista użytkowników | Hungry Fingers')

@section('content')
    <h1>Lista użytkowników </h1>


    <table class="table table-hover">
        <thead>
        <th>Nazwa</th>
        <th></th>
        <th></th>
        <th>Punkty</th>
        <th>Email</th>
        <th>Sprzedaż</th>
        <th>Opinie</th>
        <th>Status</th>
        </thead>

        <tbody>

        @foreach ($users as $user)
            <tr>
                <td><img src="{{$user->avatar}}" height="45" style="margin-right: 10px;">
                    <a href="{{URL::route('user', array($user->steamid))}}">{{$user->username}}</a>
                </td>
                <td><a href="{{$user->profileURL}}" target="_blank"><i class="fa fa-steam-square fa-2x"
                                                                       style="color: #000;" aria-hidden="true"></i></a>
                </td>
                <td>{{$user->countryCode}}</td>

                @if (empty($user->score->score))
                    <td>0</td>
                @else
                    <td>{{$user->score->score}}</td>
                @endif


                <td valign="middle">{{$user->email}}</td>
                <td></td>
                <td></td>


                @if ($user->role == 0)
                    <td>Nieaktywny</td>
                @elseif($user->role == 1)
                    <td>Użytkownik</td>
                @elseif($user->role == 10)
                    <td>Admin</td>
                @endif

            </tr>
        @endforeach

        </tbody>

    </table>





    {{ $users->render() }}



@stop