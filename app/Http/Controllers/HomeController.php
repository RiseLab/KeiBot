<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Bot;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        // Боты
		$bots = $request->user()->bots()->get();

		$activeBot = $request->user()->bots()->where('active', 1)->first();

		if (count($activeBot)){
			$activeBot = $activeBot->toArray();
		}

		return view('home', [
			'bots' => $bots,
			'activeBot' => $activeBot,
		]);
    }
}
