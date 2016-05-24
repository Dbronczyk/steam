<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;

use App\Http\Requests;
use App\Order;
use App\Opinion;
use App\Score;
use Illuminate\Support\Facades\Auth;
use App\User;
use App\Sale;


class OpinionController extends Controller
{
    public function __construct()
    {
        $this->middleware('user');
    }

    public function myOpinions()
    {
        $userID = Auth::user()->id;
        $opinions = Opinion::where('userID', $userID)->orderBy('date', 'desc')->get();

        return view('opinion.my-opinions', [
            'opinions' => $opinions,
        ]);

    }

    public function opinions($id)
    {
        //$userID = Auth::user()->id;
        $user = User::where('steamid', $id)->first();
        $opinions = Opinion::where('userID', $user->id)->orderBy('date', 'desc')->get();

        return view('opinion.opinions', [
            'opinions' => $opinions,
            'user' => $user,
        ]);
    }


    public function add($userID, $saleID)
    {

        //$user = User::where('id', $userID)->first();

        $sale = Sale::where('id', $saleID)->first();

        //$user = User::where('id', $sale->userID)->first();

        if ($sale->order->buyerID == Auth::user()->id) {
            $user = User::where('id', $sale->order->sellerID)->first();
        } elseif ($sale->order->sellerID == Auth::user()->id) {
            $user = User::where('id', $sale->order->buyerID)->first();
        }


        return view('opinion.add', [
            'user' => $user,
            'sale' => $sale,
        ]);
    }


    public function save(Request $request)
    {
        $userID = $request->input('userID'); //id osoby, która dostaje recenzje
        $saleID = $request->input('saleID');
        $status = $request->input('status');
        $op = $request->input('opinion');
        $reviewer = Auth::user()->id; //id osoby ktora pisze dana recenzje


       // dd('ID osoby, ktora dostanie recenzje: ' . $userID);


        $order = Order::where('saleID', $saleID)->first();
        $user = User::where('id', $userID)->first();

        $opinion = new Opinion;
        $score = Score::where('userID', $userID)->first();


        if ($order->buyerID == $reviewer) {
            //sprzedawca
            $opinion->what = 1;
            $route = 'purchases';

        } else {
            //kupujący
            $opinion->what = 0;
            $route = 'sold';
        }

        if (empty($score)) {
            $s = new Score;
            $s->userID = $userID;
            $s->score = 1;
            $s->save();
        } else {
            $score->score = $score->score + 1;
            $score->save();
        }

        $opinion->opinion = $op;
        $opinion->reviewer = $reviewer;
        $opinion->userID = $userID;
        $opinion->status = $status;
        $opinion->appid = $order->sale->game->appid;
        $opinion->date = time();
        $opinion->save();

        if ($order->opinion == 0) {
            $order->opinion = $reviewer;
            $order->save();
        } else {
            $order->delete();
        }

        return redirect()->route($route)->with('success', '<strong>Świetnie!</strong> Twoja opinia została zapisana!');
    }
}
