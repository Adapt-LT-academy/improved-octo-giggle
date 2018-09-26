<?php


namespace App\Tests\functional;


use App\Tests\APITester;

class PizzaOrderCest
{

    public function getResponse(APITester $I)
    {
        $I->wantTo('Check if botman message endpoint responds');
        $I->sendBotMessage('message', 'Hi');
        $I->seeResponseContainsJson(['messages' => [['text' => 'What Pizza size do you want?']]]);
        $I->sendBotMessage('message', '1');
        $I->seeResponseContainsJson(['messages' => [['text' => 'What topping do you want?']]]);
        $I->sendBotMessage('message', 'Burger');
        $I->seeResponseContainsJson(['messages' => [['text' => 'Where can we deliver your tasty pizza?']]]);
        $I->sendBotMessage('message', 'Kaunas');
        $I->seeResponseContainsJson(
            [
                'messages' =>
                    [
                        ['text' => 'Okay. That is all I need.'],
                        ['text' => 'Size: 1'],
                        ['text' => 'Topping: Burger'],
                        ['text' => 'Delivery address: Kaunas'],
                    ],
            ]
        );
    }
}
