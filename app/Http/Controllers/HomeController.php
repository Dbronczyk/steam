<?php

namespace App\Http\Controllers;

use App\Order;
use Illuminate\Http\Request;
use App\User;
use App\Game;
use App\Sale;
use App\Http\Requests;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        /*
                    $text = 'Demo';
                     if ((stripos($text, 'Demo') === false)
                         //|| (stripos($text, 'Trailer') !== false)
                        // || (stripos($text, 'Soundtrack') !== false)
                     )
                        dd('nie ma');
                    else
                        dd('jest');
    */
        /*
                $url = 'http://dbronczyk.pl/games.json';
                $content = file_get_contents($url);
                $json = json_decode($content, true);

                $i = 0;

                foreach ($json['applist']['apps']['app'] as $a) {

                    if ((stripos($a['name'], 'Demo') !== false) ||
                        (stripos($a['name'], 'Trailer') !== false) ||
                        (stripos($a['name'], 'Soundtrack') !== false) ||
                        (stripos($a['name'], 'Beta') !== false) ||
                        (stripos($a['name'], 'Server') !== false)
                    ) {
                        // do magic
                    } else {
                        //save
                        $Game[$i] = new Game();

                        $Game[$i]->appid = $a['appid'];
                        $Game[$i]->name = $a['name'];
                        $Game[$i]->save();

                        $i++;

                    }

                }

        */
        // $Game = Game::all();

        $sale = Sale::where('active', 1)
            ->where('sold', 0)
            ->orderBy('date', 'desc')
            ->paginate(20);

        return view('home.index', [
            'sale' => $sale,
            //  'app' => $Game,
        ]);
    }


    public function consent()
    {
        $ok = 0;

        if (Auth::guest()) {
            return redirect('steam');
        }

        if (Auth::user()->role == 0) {
            $ok = 1;
        } else {
            $ok = 2;
        }

        return view('home.consent', [
            'ok' => $ok,
        ]);
    }

    public function json($phrase)
    {
        $game = Game::where('name', 'LIKE', '%' . $phrase . '%')->get(['name', 'appid']);

        return response()->json($game);
    }

    public function regulamin()
    {
        return view('home.regulamin', [

        ]);
    }


    public function showDeal($id)
    {
        //$user = User::where('steamid', $id)->first();
        $deal = Sale::where('id', $id)->where('active', 1)->where('sold', 0)->first();

        if (empty($deal)) {
            return redirect()->route('home');
        }

        //dd($deal);

        $games = Sale::where('appid', $deal->appid)
            ->where('id', '!=', $deal->id)
            ->where('active', 1)
            ->where('sold', 0)
            ->orderBy('price', 'asc')
            ->paginate(20);

        return view('home.showDeal', [
            'deal' => $deal,
            'games' => $games,
        ]);
    }


    public function ICU()
    {

        return view('home.ICU', [
        ]);
    }

    public function search($appid, $slug)
    {

        $sale = Sale::where('appid', $appid)
            ->where('active', 1)
            ->where('sold', 0)
            ->orderBy('price', 'asc')
            ->first();

        $games = null;

        if (!empty($sale)) {
            $games = Sale::where('appid', $appid)
                ->where('id', '!=', $sale->id)
                ->where('active', 1)
                ->where('sold', 0)
                ->orderBy('price', 'asc')
                ->paginate(20);
        }

        return view('home.search', [
            'sale' => $sale,
            'games' => $games,
        ]);
    }


    public function save(Request $request)
    {
        $email = $request->input('email');

        $user = User::where('id', Auth::user()->id)->first();

        $user->email = $email;
        $user->save();

        return redirect()->back()->with('success', '<strong>Świetnie!</strong> Twoje dane zostały zapisane!');
    }


}

