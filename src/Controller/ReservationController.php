<?php

namespace App\Controller;

use App\Entity\Reservation;
use App\Form\ReservationType;
use App\Repository\ReservationRepository;
use Doctrine\Persistence\ManagerRegistry;
use SebastianBergmann\Environment\Console;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class ReservationController extends AbstractController
{
    #[Route('/reservation', name: 'app_reservation')]
    public function index(): Response
    {
        $reservations = $this->getDoctrine()->getRepository(Reservation::class)->findAll();
        return $this->render('reservation/index.html.twig', [
            'controller_name' => 'ReservationController',
            "reservations" => $reservations,
        ]);
    }

    #[Route('/evenement/{id}/createReservation', name: 'app_reservation_create')]
    public function createReservation(Request $request, ManagerRegistry $managerRegistry): Response
    {
        //create reservation
        $reservation = new Reservation();
        $form = $this->createForm(ReservationType::class, $reservation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $managerRegistry->getManager()->persist($reservation);
            $managerRegistry->getManager()->flush();
            $selectedEvent = $reservation->getEvenement();
            // decrement event places
            $selectedEvent->setNombrePlace($selectedEvent->getNombrePlace() - 1);
            $managerRegistry->getManager()->persist($selectedEvent);
            $managerRegistry->getManager()->flush();

            $this->addFlash('success', 'Reservation created successfully');
            return $this->redirectToRoute('app_reservation');
        }

        return $this->render('reservation/create.html.twig', [
            'controller_name' => 'ReservationController',
            'form' => $form->createView(),
        ]);
    }

    // remove reservation
    #[Route('/reservation/{id}/delete', name: 'app_reservation_delete')]
    public function removeReservation(Request $request, ManagerRegistry $doctrine, ReservationRepository $reservationRepository, int $id): Response
    {
        $reservation = $reservationRepository->find($id);
        $entityManager = $doctrine->getManager();
        $entityManager->remove($reservation);
        $entityManager->flush();
        return $this->redirectToRoute('/reservation');
    }
}
