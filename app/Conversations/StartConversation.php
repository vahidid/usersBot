<?php

namespace App\Conversations;

use BotMan\BotMan\Messages\Conversations\Conversation;
use BotMan\BotMan\Messages\Incoming\Answer;
use BotMan\BotMan\Messages\Outgoing\Actions\Button;
use BotMan\BotMan\Messages\Outgoing\Question;

class StartConversation extends Conversation
{
    protected $fullname;

    protected $phoneNumber;
    /**
     * First question
     */
    public function askReason()
    {
        $question = Question::create("به ربات کاربران خوش آمدید. یکی از گزینه های زیر را انتخاب کنید")
            ->fallback('Unable to ask question')
            ->callbackId('ask_reason')
            ->addButtons([
                Button::create('ثبت نام')->value('register'),
            ]);

        return $this->ask($question, function (Answer $answer) {
            if ($answer->isInteractiveMessageReply()) {
                if ($answer->getValue() === 'register') {
                    //$joke = json_decode(file_get_contents('http://api.icndb.com/jokes/random'));
                    $this->askName();
                }
            }
        });
    }

    public function askName()
    {

        $question = Question::create("نام و نام خانوادگی خود را وارد کنید")
            ->fallback('Unable to ask question')
            ->callbackId('ask_fullname');

        return $this->ask($question, function (Answer $answer) {
            $this->fullname = $answer->getText();

            $this->say('خیلی خوش آمدید ' . $this->fullname);
            $this->askPhoneNumber();
        });

    }

    public function askPhoneNumber()
    {
        $question = Question::create("لطفا شماره تماس خود را وارد کنید.")
            ->fallback('Unable to ask question')
            ->callbackId('ask_phoneNumber');

        $this->ask($question, function (Answer $answer) {
            $this->phoneNumber = $answer->getText();

            $user = new App\User;
            $user->name = $this->fullname;
            $user->phoneNumber = $this->phoneNumber;
            $user->save();
            $this->say('شما با موفقیت ثبت نام شدید. تشکر از حمایت شما');
        });
    }

    /**
     * Start the conversation
     */
    public function run()
    {
        $this->askReason();
    }
}
