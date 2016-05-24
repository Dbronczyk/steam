<?php

namespace App\Http\Controllers;

use App\Game;
use Illuminate\Http\Request;
use App\User;
use App\Score;

use App\Http\Requests;
use App\Report;

class AdminController extends Controller
{
    public function __construct()
    {
        $this->middleware('admin');
    }

    public function index()
    {

        return view('admin.index', [
            //'user' => $user,
        ]);
    }

    public function games()
    {
        $games = Game::orderBy('appid', 'asc')->paginate(20);

        return view('admin.games', [
            'games' => $games,
        ]);
    }

    public function users()
    {
        $users = User::paginate(20);

        return view('admin.users', [
            'users' => $users,
        ]);
    }

    public function user($steamid)
    {
        $user = User::where('steamid', $steamid)->first();

        return view('admin.user', [
            'user' => $user,
        ]);
    }


    public function userUpdate(Request $request, $steamid)
    {
        $email = $request->input('email');
        $name = $request->input('name');
        $status = $request->input('status');
        $username = $request->input('steam');
        $score = $request->input('score');
        $created = $request->input('created');


        $user = User::where('steamid', $steamid)->first();

        $user->email = $email;
        $user->name = $name;
        $user->username = $username;
        $user->role = $status;
        $user->created_at = $created;

        if (empty($user->score->score)) {
            $s = new Score;
            $s->userID = $user->id;
            $s->score = $score;
            $s->save();
        } else {
            $user->score->score = $score;
            $user->score->save();
        }


        //$user->score->score = $score;
        $user->save();
        //$user->score->save();

        return redirect()->back()->with('success', '<strong>Świetnie!</strong> Twoje dane zostały zapisane!');
    }

    public function remove($appid)
    {
        $game = Game::find($appid);
        $game->delete();
    }

    public function add(Request $request)
    {
        $name = $request->input('name');
        $appid = $request->input('appid');

        $game = new Game;
        $game->name = $name;
        $game->appid = $appid;

        $game->save();

        return back()->with('success', '<strong>Świetnie!</strong> Gra została dodana!');
        //->withInput() uzupełnia inputy wcześniej wpisanymi wartościami

    }


}
