<?php

namespace App\Http\Controllers;

use App\Report;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests;

class ReportController extends Controller
{
    public function save(Request $request)
    {
        $reported = $request->input('userID');
        $who = $user1 = Auth::user()->id;
        $reason = $request->input('reason');

        $report = new Report;

        $report->reason = $reason;
        $report->who = $who;
        $report->reported = $reported;
        $report->date = time();

        $report->save();

        return redirect()->back()->with('success', '<strong>Dziękujemy!</strong> Twoje zgłoszenie zostało przyjęte.');
    }
}
