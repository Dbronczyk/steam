<?php

namespace App\Http\Controllers;

use App\Opinion;
use App\Sale;
use Illuminate\Http\Request;
use App\User;
use App\Http\Requests;
use App\Score;
use App\Report;

class ProfilController extends Controller
{
    public function __construct()
    {
        $this->middleware('user');
    }


    public function profil()
    {

        return view('profil.profil', [
            //'deal' => $deal,
            //'games' => $games,
        ]);
    }

    public function showProfil($id)
    {
        $user = User::where('steamid', $id)->first();
        $sale = Sale::where('userID', $user->id)->where('active', 1)->where('sold', 0)->orderBy('date', 'desc')->paginate(20);
        $score = Score::where('userID', $user->id)->first();
        $opinions = Opinion::where('userID', $user->id)->orderBy('date', 'desc')->take(4)->get();

        return view('profil.showProfil', [
            'user' => $user,
            'sale' => $sale,
            'score' => $score,
            'opinions' => $opinions,
        ]);
    }
}
