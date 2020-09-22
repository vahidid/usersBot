<?php

namespace App\Http\Controllers;

use App\Conversations\StartConversation;
use BotMan\BotMan\BotMan;

class BotManController extends Controller
{
    /**
     * Place your BotMan logic here.
     */
    public function handle()
    {
        $botman = app('botman');

        $botman->listen();
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function tinker()
    {
        return view('tinker');
    }

    /**
     * Loaded through routes/botman.php
     * @param  BotMan $bot
     */
    public function startConversation(BotMan $bot)
    {
        // Access user
        $user = $bot->getUser();
        // Access ID
        $id = $user->getId();

        $bot->startConversation(new StartConversation($id));
    }
}
