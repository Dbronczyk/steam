<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Sale;
use App\Order;
use App\Price;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

//use Mail;


class SaleController extends Controller
{
    public function __construct()
    {
        $this->middleware('user');
    }

    public function sale()
    {
        return view('sale.sale', [
        ]);
    }

    public function price($appid)
    {
        $min = Price::where('appid', $appid)->min('price');
        $max = Price::where('appid', $appid)->max('price');
        $cmin = Sale::where('appid', $appid)->min('price');

        $price = array(
            'min' => $min,
            'max' => $max,
            'cmin' => $cmin,
        );

        return response()->json($price);
    }


    public function saveSale(Request $request)
    {

        $ids = $request->input('ids');
        $prices = $request->input('prices');
        $desc = $request->input('desc');


        $i = explode(";", $ids);
        unset($i[count($i) - 1]);
        $p = explode(";", $prices);
        unset($p[count($p) - 1]);
        $d = explode(";", $desc);
        unset($d[count($d) - 1]);

        for ($j = 0; $j < count($i); $j++) {
            if ($i[$j] == '') {
                return redirect()->route('sale')->with('error', '<strong>Błąd!</strong> Nie rozpoznano gry!');
            }
        }

        //dd($i);

        $userID = Auth::user()->id;
        $data = time();

        for ($j = 0; $j < count($i); $j++) {
            $Sale[$j] = new Sale();

            $Sale[$j]->appid = $i[$j];
            $Sale[$j]->price = str_replace(",", ".", $p[$j]);
            $Sale[$j]->desc = $d[$j];
            $Sale[$j]->userID = $userID;
            $Sale[$j]->date = $data;

            $Sale[$j]->save();
        }

        //return back()->with('success', '<strong>Świetnie!</strong> Twoja oferta została zapisana!');
        return redirect()->route('my-sell')->with('success', '<strong>Świetnie!</strong> Twoja oferta została zapisana!');

    }

    public function mySell()
    {
        $userID = Auth::user()->id;

        $sell = Sale::where('userID', $userID)->where('sold', 0)->orderBy('date', 'desc')->paginate(10);

        return view('sale.my-sell', [
            'sell' => $sell,
        ]);
    }

    public function sold()
    {
        $userID = Auth::user()->id;
        $orders = Order::where('sellerID', $userID)->orderBy('date', 'desc')->paginate(10);

        return view('sale.my-sold', [
            'orders' => $orders,
        ]);
    }

    public function remove($id)
    {
        $userID = Auth::user()->id;
        $game = Sale::where('id', $id)->where('userID', $userID);
        $game->delete();
    }


    public function update($id)
    {
        $userID = Auth::user()->id;
        $game = Sale::where('id', $id)->where('userID', $userID)->first();

        if (empty($game)) {
            return redirect()->route('ICU');
        }

        if ($game->active == 0) {
            $game->active = 1;
            $game->save();
        } else {
            $game->active = 0;
            $game->save();
        }

        //return response()->json($game);
    }


    public function buyConfirm($id)
    {
        $userID = Auth::user()->id;
        $game = Sale::where('id', $id)->where('active', 1)->where('sold', 0)->first();


        if (empty($game)) {
            return redirect()->route('/')->with('error', '<strong>Ktoś był szybszy!</strong> Ta gra została już przez kogoś kupion!');
        } else {

            if ($game->user->id == $userID) {
                return redirect()->route('ICU');
            }

            $game->sold = 1;
            $game->save();

            $order = new Order;
            $order->buyerID = $userID;
            $order->sellerID = $game->userID;
            $order->saleID = $id;
            $order->date = time();

            $order->save();

            return redirect()->route('purchases')->with('success', '<strong>Świetnie!</strong> Dokonałeś zakupu. Teraz skontaktuj się ze sprzedawca.');
        }
    }


    public function buy($id)
    {
        $sale = Sale::where('id', $id)->where('active', 1)->where('sold', 0)->first();

        return view('sale.buy', [
            'sale' => $sale,
        ]);
    }

//MAIL_DRIVER=smtp
//MAIL_HOST=smtp.gmail.com
//MAIL_PORT=587
//MAIL_USERNAME=damianek2326@gmail.com
//MAIL_PASSWORD=udidfvxplkaihkmv
//MAIL_ENCRYPTION=tls


    public function purchases()
    {
        $userID = Auth::user()->id;

        $orders = Order::where('buyerID', $userID)->where('opinion', '!=', $userID)->orderBy('date', 'desc')->get();

        return view('sale.purchases', [
            'orders' => $orders,
        ]);
    }

    public function removeOrder($id)
    {
        $order = Order::where('id', $id)->first();
        $userID = Auth::user()->id;

//        Mail::send('email.test', ['user' => 'Damian'], function ($m) {
//            //    $m->from('hello@app.com', 'Your Application');
//            $m->to('damianek2326@gmail.com', 'Damian')->subject('Your Reminder!');
//        });

        if ($order->remove == $userID or empty($order)) {
            return redirect()->route('ICU');
        }

        if ($order->remove == 0) {
            $order->remove = $userID;
            $order->save();
            $text = '<strong>Świetnie!</strong> Prośba o usunięcie tego zamówienie została wysłana.';
            //email do drugiej osoby o usunięciu i potrośba o potwierdzenie.
        } else {
            $order->delete();
            $text = '<strong>Świetnie!</strong> Zamówienie zostało usunięte.';
            //email do obydwu osób, ze zamówienie zostało usunięte
        }

        return redirect()->back()->with('success', $text);

    }

}
