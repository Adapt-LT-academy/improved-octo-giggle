<?php


namespace App\Service;

use App\Traits\ContainerAwareConversationTrait;
use BotMan\BotMan\Messages\Conversations\Conversation;
use BotMan\BotMan\Messages\Incoming\IncomingMessage;
use BotMan\BotMan\Messages\Outgoing\Actions\Button;
use BotMan\BotMan\Messages\Outgoing\Question;
use App\Service\OptionsService;

/**
 * Class PizzaOrderConversation
 */
class PizzaOrderConversation extends Conversation
{

    use ContainerAwareConversationTrait;

    protected $size;

    protected $topping;

    protected $address;

    public function run()
    {
        $toppings = $this->getContainer()->get(OptionsService::class)->getToppings();

        $buttons = [];

        foreach ($toppings as $topping)
        {
            $buttons[] = Button::create($topping->getName())->value($topping->getId());
        }

        $question = Question::create('What Pizza size do you want?');
        $question->addButtons(
            $buttons
        );
        $this->ask(
            $question,
            function ($answer) {
                $this->size = $answer->getText();
                $this->askTopping();
            }
        );
    }

    public function askTopping()
    {
        $question = Question::create('What topping do you want?');
        $question->addButtons(
            [
                Button::create('🌭')->value('Hot Dog'),
                Button::create('🍔')->value('Burger'),
                Button::create('🍟')->value('Fries'),
            ]
        );
        $this->ask(
            $question,
            function ($answer) {
                $this->topping = $answer->getText();
                $this->askAddress();
            }
        );
    }

    public function askAddress()
    {
        $this->ask(
            'Where can we deliver your tasty pizza?',
            function ($answer) {
                $this->address = $answer->getText();
                $this->say('Okay. That is all I need.');
                $this->say('Size: '.$this->size);
                $this->say('Topping: '.$this->topping);
                $this->say('Delivery address: '.$this->address);
            }
        );
    }

    public function stopConversation(IncomingMessage $message)
    {
        return $message->getMessage() === 'stop';
    }

}
