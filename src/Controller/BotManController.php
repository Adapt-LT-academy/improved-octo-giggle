<?php


namespace App\Controller;


use App\Service\BotService;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use BotMan\BotMan\BotMan;
use BotMan\BotMan\BotManFactory;
use BotMan\BotMan\Drivers\DriverManager;
use BotMan\BotMan\Middleware\ApiAi;
class BotManController extends Controller
{

    /**
     * @Route(path="/", methods={"GET"}, name="botman")
     */
    public function botMan()
    {
        return $this->render('botman.html.twig');
    }

    /**
     * @Route("/message", name="message")
     */
    function messageAction(Request $request, BotService $botService)
    {
        // Create a BotMan instance, using the WebDriver
        DriverManager::loadDriver(\BotMan\Drivers\Web\WebDriver::class);
        $botman = BotManFactory::create([]); //No config options required
        //Setup DialogFlow middleware
        $dialogflow = ApiAi::create('s0meRand0mT0ken')->listenForAction();
        $botman->middleware->received($dialogflow);
        // Give the bot some things to listen for.
        $botman->hears('(hello|hi|hey)', function (BotMan $bot) use ($botService) {
            $bot->reply($botService->handleHello());
        });
        $botman->hears('(what night|when) is club night.*', function (BotMan $bot) use ($botService) {
            $bot->reply($botService->handleClubNights());
        });
        $botman->hears('_ENROLMENT_', function (Botman $bot) use ($botService) {
            //$extras = $bot->getMessage()->getExtras();
            $bot->reply($botService->handleEnrolment());
        })->middleware($dialogflow);
        $botman->hears('_INSURANCE_', function (Botman $bot) use ($botService) {
            $bot->reply($botService->handleInsurance());
        })->middleware($dialogflow);
        $botman->hears('_MEMBERSHIP_', function (Botman $bot) use ($botService) {
            $bot->reply($botService->handleMembership());
        })->middleware($dialogflow);
        // Start listening
        $botman->listen();
        //Send an empty response (Botman has already sent the output itself - https://github.com/botman/botman/issues/342)
        return new Response();
    }

}
