<?php

namespace App\Controller;

use App\Entity\Period;
use App\Form\PeriodType;
use App\Repository\PeriodRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/period")
 */
class PeriodController extends AbstractController
{
    /**
     * @Route("/", name="period_index", methods={"GET"})
     */
    public function index(PeriodRepository $periodRepository): Response
    {
        return $this->render('period/index.html.twig', [
            'periods' => $periodRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="period_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $period = new Period();
        $form = $this->createForm(PeriodType::class, $period);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($period);
            $entityManager->flush();

            return $this->redirectToRoute('period_index');
        }

        return $this->render('period/new.html.twig', [
            'period' => $period,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="period_show", methods={"GET"})
     */
    public function show(Period $period): Response
    {
        return $this->render('period/show.html.twig', [
            'period' => $period,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="period_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Period $period): Response
    {
        $form = $this->createForm(PeriodType::class, $period);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('period_index', [
                'id' => $period->getId(),
            ]);
        }

        return $this->render('period/edit.html.twig', [
            'period' => $period,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="period_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Period $period): Response
    {
        if ($this->isCsrfTokenValid('delete'.$period->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($period);
            $entityManager->flush();
        }

        return $this->redirectToRoute('period_index');
    }
}
