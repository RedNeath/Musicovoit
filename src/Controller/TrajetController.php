<?php

namespace App\Controller;

use App\Entity\Trajet;
use DateTime;
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

            default:
                $nextLocale = "";
        }

        return $this->render('trajet/index.html.twig', [
            'ads' => $ads,
            'nextLocale' => $nextLocale
        ]);
    }

    /**
     * @Route("/search/{_locale}/", name="trajets.search")
     */
    public function search(string $_locale): Response {

        if (!isset($_GET['from']) ||
            !isset($_GET['to']) ||
            !isset($_GET['on']) ||
            !isset($_GET['with'])
        ) {
            return $this->redirectToRoute('app_trajet');
        }


        $ads = $this->getDoctrine()->getRepository(Trajet::class)->search(
            $_GET['from'],
            $_GET['to'],
            new DateTime($_GET['on']),
            (int) $_GET['with']
        );

        switch ($_locale) {
            case "en":
                $nextLocale = "fr";
                break;

            case "fr":
                $nextLocale = "en";
                break;

            default:
                $nextLocale = "";
        }

        return $this->render('trajet/search.html.twig', [
            'ads' => $ads,
            'from' => $_GET['from'],
            'to' => $_GET['to'],
            'on' => new DateTime($_GET['on']),
            'nextLocale' => $nextLocale
        ]);
    }

    /**
     * @Route("/search/", name="search.localeless")
     */
    public function localeless_search(): Response {
        return $this->render('redirect_to_default_locale.html.twig');
    }

    /**
     * @Route("/", name="localeless")
     */
    public function localeless_index(): Response {
        return $this->render('redirect_to_default_locale.html.twig');
    }
}
