<?php

namespace App\Controller;


use App\Form\JokeType;
use App\Service\JokeFetcher;
use App\Service\Notifier;
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
     * @param Notifier $notifier
     * @return \Symfony\Component\HttpFoundation\Response
     * @throws \Exception
     */
    public function index(Request $request, JokeFetcher $jokeFetcher, Notifier $notifier)
    {
        $form = $this->createForm(JokeType::class);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            $data = $form->getData();
            $joke = $jokeFetcher->getRandomJokeFromCategory($data['category']);

            $notifier->sendJokeToEmail($data['email'], $data['category'], $joke);
            $notifier->saveJokeToFile($data['category'], $joke);

            $this->addFlash("success", "Шутка была отправлена ​​на вашу электронную почту");
        }

        return $this->render('site/index.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
