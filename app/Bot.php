<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Bot extends Model
{
	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = [
		'name', 'url', 'password', 'active'
	];

    /*
     * Получить владельца бота
     */
	public function user()
	{
		return $this->belongsTo('App\User');
	}
}
