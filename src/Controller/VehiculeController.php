<?php

namespace App\Controller;

use App\Entity\Vehicule;
use App\Form\VehiculeType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class VehiculeController extends AbstractController
{
    /**
     * @Route("/vehicule", name="app_vehicule")
     */
    public function index(): Response
    {
        // Récupérer la liste des véhicules depuis le repository
        $vehicules = $this->getDoctrine()->getRepository(Vehicule::class)->findAll();

        // Afficher la liste des véhicules dans le template
        return $this->render('vehicule/index.html.twig', [
            'vehicules' => $vehicules,
        ]);
    }

    /**
     * @Route("/vehicule/{id}", name="app_vehicule_show", requirements={"id"="\d+"})
     */
    public function show(Vehicule $vehicule): Response
    {
        // Afficher les détails d'un véhicule spécifique
        return $this->render('vehicule/show.html.twig', [
            'vehicule' => $vehicule,
        ]);
    }

    /**
     * @Route("/vehicule/create", name="app_vehicule_create")
     */
    public function create(Request $request): Response
    {
        $vehicule = new Vehicule();

        // Créer le formulaire en utilisant le type de formulaire VehiculeType
        $form = $this->createForm(VehiculeType::class, $vehicule);

        // Traiter la soumission du formulaire
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($vehicule);
            $entityManager->flush();

            // Rediriger vers la page de liste des véhicules
            return $this->redirectToRoute('app_vehicule');
        }

        // Afficher le formulaire dans le template
        return $this->render('vehicule/create.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/vehicule/{id}/edit", name="app_vehicule_edit", requirements={"id"="\d+"})
     */
    public function edit(Request $request, Vehicule $vehicule): Response
    {
        // Créer le formulaire en utilisant le type de formulaire VehiculeType et le véhicule existant
        $form = $this->createForm(VehiculeType::class, $vehicule);

        // Traiter la soumission du formulaire
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            // Rediriger vers la page de détails du véhicule
            return $this->redirectToRoute('app_vehicule_show', ['id' => $vehicule->getId()]);
        }

        // Afficher le formulaire dans le template
        return $this->render('vehicule/edit.html.twig', [
            'form' => $form->createView(),
            'vehicule' => $vehicule,
        ]);
    }

    /**
     * @Route("/vehicule/{id}/delete", name="app_vehicule_delete", requirements={"id"="\d+"})
     */
    public function delete(Request $request, Vehicule $vehicule): Response
    {
        if ($request->isMethod('POST')) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($vehicule);
            $entityManager->flush();

            // Rediriger vers la page de liste des véhicules
            return $this->redirectToRoute('app_vehicule');
        }

        // Afficher la confirmation de suppression dans le template
        return $this->render('vehicule/delete.html.twig', [
            'vehicule' => $vehicule,
        ]);
    }
}
