<?php


namespace App\Service;

use BotMan\BotMan\Messages\Conversations\Conversation;
use BotMan\BotMan\Messages\Incoming\Answer;

/**
 * Class PizzaOrderConversation
 */
class PizzaOrderConversation extends Conversation
{

    /**
     * @var string
     */
    protected $size;

    /**
     * @var string
     */
    protected $topping;

    /**
     * @var string
     */
    protected $secondTopping;

    /**
     *
     */
    public function askSize()
    {
        $this->ask(
            'Hello! What size of pizza do you want?',
            function (Answer $answer) {
                // Save result
                $this->size = $answer->getText();

                $this->askTopping();
            }
        );
    }

    /**
     *
     */
    public function askTopping()
    {
        $this->ask(
            'What main topping do you want?',
            function (Answer $answer) {
                // Save result
                $this->topping = $answer->getText();

                $this->askSecondTopping();
            }
        );
    }

    /**
     *
     */
    public function askSecondTopping()
    {
        $this->ask(
            'What second topping do you want?',
            function (Answer $answer) {
                // Save result
                $this->secondTopping = $answer->getText();

                $this->say(
                    sprintf(
                        'Nice choice: Size: %s, Main topping: %s, Second topping: %s ',
                        $this->size,
                        $this->topping,
                        $this->secondTopping
                    )
                );
            }
        );

    }

    /**
     * @return mixed
     */
    public function run()
    {
        $this->askSize();
    }

}
