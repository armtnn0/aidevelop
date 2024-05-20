<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class FortuneController extends Controller
{
    
    public function index() {
        $date = date('Y/m/d');
        $resp = Http::get('http://api.jugemkey.jp/api/horoscope/free/' . $date);
        $resp = $resp->json();
        $horoscope = $resp['horoscope'];
        $dateFortune = $horoscope[$date];
        array_multisort(
            array_column($dateFortune, 'rank'), SORT_ASC, $dateFortune
        );

        return view('fortune', compact('dateFortune'));
    }
}
