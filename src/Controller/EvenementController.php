<?php

namespace App\Controller;

use App\Entity\Evenement;
use App\Form\EvenementType;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class EvenementController extends AbstractController
{
    #[Route('/evenement', name: 'app_evenement_show')]
    public function index(): Response
    {
        // fetch events
        $events = $this->getDoctrine()->getRepository(Evenement::class)->findAll();
        
        return $this->render('evenement/index.html.twig', [
            'controller_name' => 'EvenementController',
            'events' => $events,
        ]);
    }

    #[Route('/evenement/create', name: 'app_evenement_show')]
    public function createEvent(Request $request, ManagerRegistry $managerRegistry): Response
    {
        $event = new Evenement();
        $form = $this->createForm(EvenementType::class, $event);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $managerRegistry->getManager()->persist($event);
            $managerRegistry->getManager()->flush();
            return $this->redirectToRoute('app_evenement_show');
        }
        return $this->render('evenement/create.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
