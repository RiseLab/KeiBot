<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Bot;

class BotController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
		$this->validate($request, [
			'name' => 'required',
			'url' => 'required',
		]);

		$request->user()->bots()->where('active', 1)->update([
			'active' => 0,
		]);

		$request->user()->bots()->create([
			'name' => $request->name,
			'url' => $request->url,
			'password' => $request->password,
		]);

		return redirect('/home');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
//    public function update(Request $request, $id)
//    {
//        //
//    }

	/**
	 * Update the given bot.
	 *
	 * @param  Request  $request
	 * @param  Bot  $bot
	 * @return Response
	 */
	public function update(Request $request, Bot $bot)
	{
		$this->authorize('update', $bot);

		if (!isset($request->activate)){
			$this->validate($request, [
				'name' => 'required',
				'url' => 'required',
			]);

			$bot->update([
				'name' => $request->name,
				'url' => $request->url,
				'password' => $request->password,
			]);
		} else {
			$request->user()->bots()->where('active', 1)->update([
				'active' => 0,
			]);

			$bot->update([
				'active' => 1,
			]);
		}

		return redirect('/home');
	}

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
//    public function destroy($id)
//    {
//		//
//    }

	/**
	 * Destroy the given bot.
	 *
	 * @param  Request  $request
	 * @param  Bot  $bot
	 * @return Response
	 */
	public function destroy(Request $request, Bot $bot)
	{
		$this->authorize('destroy', $bot);

		$bot->delete();

		if (count($request->user()->bots()->first())) {
			$request->user()->bots()->first()->update([
				'active' => 1,
			]);
		}

		return redirect('/home');
	}
}
