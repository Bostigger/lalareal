<?php

namespace App\Http\Controllers;

use App\Events\MoneyMultiplierEvent;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;

class GameController extends Controller
{
    public function GambleNow(Request $request)
    {
        $request->validate([
            "money"=>"Required",
            "multiplier"=>"Required"
        ]);

       Artisan::call('game:execute',[
          'money'=>$request->money,
          'multiplier'=>$request->multiplier
       ]);
        return response()->json('Bet Placed! GoodLuck');
    }
}
