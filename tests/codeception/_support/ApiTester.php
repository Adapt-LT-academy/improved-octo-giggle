<?php

/**
 * Inherited Methods
 * @method void wantToTest($text)
 * @method void wantTo($text)
 * @method void execute($callable)
 * @method void expectTo($prediction)
 * @method void expect($prediction)
 * @method void amGoingTo($argumentation)
 * @method void am($role)
 * @method void lookForwardTo($achieveValue)
 * @method void comment($description)
 * @method \Codeception\Lib\Friend haveFriend($name, $actorClass = null)
 *
 * @SuppressWarnings(PHPMD)
 */
class ApiTester extends \Codeception\Actor
{

    use \_generated\ApiTesterActions;

    protected $userId;

    /**
     * Define custom actions here
     */

    public function sendBotMessage($url, $message)
    {

        if ($this->userId === null) {
            $this->userId = random_int(100, 10000);
        }

        $this->sendPOST(
            $url,
            [
                'driver'      => 'web',
                'userId'      => $this->userId,
                'message'     => $message,
                'attachment'  => null,
                'Interactive' => 0,
            ]
        );
    }
}
