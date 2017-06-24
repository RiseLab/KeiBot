<?php

namespace App\Policies;

use App\User;
use App\Bot;
use Illuminate\Auth\Access\HandlesAuthorization;

class BotPolicy
{
    use HandlesAuthorization;

    /**
     * Create a new policy instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

	/**
	 * Determine if the given user can delete the given bot.
	 *
	 * @param  User  $user
	 * @param  Bot  $bot
	 * @return bool
	 */
	public function destroy(User $user, Bot $bot)
	{
		return $user->id === $bot->user_id;
	}

	/**
	 * Determine if the given user can update the given bot.
	 *
	 * @param  User  $user
	 * @param  Bot  $bot
	 * @return bool
	 */
	public function update(User $user, Bot $bot)
	{
		return $user->id === $bot->user_id;
	}
}
