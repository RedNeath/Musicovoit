<?php

namespace App\Controller;

use App\Entity\Trajet;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class TrajetController extends AbstractController
{
    /**
     * @Route("/{_locale}/", name="app_trajet")
     */
    public function index(string $_locale): Response
    {
        $ads = $this->getDoctrine()->getRepository(Trajet::class)->findAll();

        switch ($_locale) {
            case "en":
                $nextLocale = "fr";
                break;

            case "fr":
                $nextLocale = "en";
                break;
        }

        return $this->render('trajet/index.html.twig', [
            'ads' => $ads,
            'nextLocale' => $nextLocale
        ]);
    }
}
