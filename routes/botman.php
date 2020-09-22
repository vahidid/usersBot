<?php
use App\Http\Controllers\BotManController;

$botman = resolve('botman');

$botman->hears('/start', BotManController::class . '@startConversation');

/* $botman->hears('Hi', function ($bot) {
$bot->reply('Hello!');
});
$botman->hears('Start conversation', BotManController::class.'@startConversation');
 */
