<?php

namespace App\Controller;


use App\Form\JokeType;
use App\Service\JokeFetcher;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class SiteController
 * @package App\Controller
 */
class SiteController extends AbstractController
{
    /**
     * @Route("/", name="index")
     * @param Request $request
     * @param JokeFetcher $jokeFetcher
     * @param \Swift_Mailer $mailer
     * @return \Symfony\Component\HttpFoundation\Response
     * @throws \Exception
     */
    public function index(Request $request, JokeFetcher $jokeFetcher, \Swift_Mailer $mailer)
    {
        $form = $this->createForm(JokeType::class);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            $data = $form->getData();
            $joke = $jokeFetcher->getRandomJokeFromCategory($data['category']);

            $message = (new \Swift_Message('Случайная шутка из ' . $data['category']))
                ->setFrom(getenv('EMAIL_FROM'))
                ->setTo($data['email'])
                ->setBody(
                    $this->renderView(
                        'emails/joke.html.twig',
                        [
                            'joke' => $joke,
                            'category' => $data['category']
                        ]
                    ),
                    'text/html'
                );
            $mailer->send($message);

            $this->addFlash("success", "Шутка была отправлена ​​на вашу электронную почту");
        }

        return $this->render('site/index.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
