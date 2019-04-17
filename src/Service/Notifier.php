<?php

namespace App\Service;


use Twig\Environment as Twig;

/**
 * Class Notifier
 * @package App\Service
 */
class Notifier
{
    /** @var \Swift_Mailer */
    private $mailer;
    /** @var Twig  */
    private $templating;

    /**
     * Notifier constructor.
     * @param \Swift_Mailer $mailer
     * @param Twig $templating
     */
    public function __construct(\Swift_Mailer $mailer, Twig $templating)
    {
        $this->mailer = $mailer;
        $this->templating = $templating;
    }

    /**
     * @param $emailTo
     * @param $category
     * @param $joke
     * @throws \Twig\Error\Error
     */
    public function sendJokeToEmail($emailTo, $category, $joke)
    {
        $message = (new \Swift_Message('Случайная шутка из ' . $category))
            ->setFrom(getenv('EMAIL_FROM'))
            ->setTo($emailTo)
            ->setBody(
                $this->templating->render(
                    'emails/joke.html.twig',
                    [
                        'joke' => $joke,
                        'category' => $category
                    ]
                ),
                'text/html'
            );
        $this->mailer->send($message);
    }

    /**
     * @param $category
     * @param $joke
     */
    public function saveJokeToFile($category, $joke)
    {
        //todo
    }

}