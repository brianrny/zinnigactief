<?php

namespace App\Controller;

use App\Entity\EventHasActivity;
use App\Form\EventHasActivityType;
use App\Repository\EventHasActivityRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/eventactivity")
 */
class EventHasActivityController extends AbstractController
{
    /**
     * @Route("/", name="event_has_activity_index", methods={"GET"})
     */
    public function index(EventHasActivityRepository $eventHasActivityRepository): Response
    {
        return $this->render('event_has_activity/index.html.twig', [
            'event_has_activities' => $eventHasActivityRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="event_has_activity_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $eventHasActivity = new EventHasActivity();
        $form = $this->createForm(EventHasActivityType::class, $eventHasActivity);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($eventHasActivity);
            $entityManager->flush();

            return $this->redirectToRoute('event_has_activity_index');
        }

        return $this->render('event_has_activity/new.html.twig', [
            'event_has_activity' => $eventHasActivity,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="event_has_activity_show", methods={"GET"})
     */
    public function show(EventHasActivity $eventHasActivity): Response
    {
        return $this->render('event_has_activity/show.html.twig', [
            'event_has_activity' => $eventHasActivity,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="event_has_activity_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, EventHasActivity $eventHasActivity): Response
    {
        $form = $this->createForm(EventHasActivityType::class, $eventHasActivity);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('event_has_activity_index', [
                'id' => $eventHasActivity->getId(),
            ]);
        }

        return $this->render('event_has_activity/edit.html.twig', [
            'event_has_activity' => $eventHasActivity,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="event_has_activity_delete", methods={"DELETE"})
     */
    public function delete(Request $request, EventHasActivity $eventHasActivity): Response
    {
        if ($this->isCsrfTokenValid('delete'.$eventHasActivity->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($eventHasActivity);
            $entityManager->flush();
        }

        return $this->redirectToRoute('event_has_activity_index');
    }
}
