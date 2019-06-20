<?php

namespace App\Controller;

use App\Entity\Attend;
use App\Form\AttendType;
use App\Repository\AttendRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/attend")
 */
class AttendController extends AbstractController
{
    /**
     * @Route("/", name="attend_index", methods={"GET"})
     */
    public function index(AttendRepository $attendRepository): Response
    {
        return $this->render('attend/index.html.twig', [
            'attends' => $attendRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="attend_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $attend = new Attend();
        $form = $this->createForm(AttendType::class, $attend);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($attend);
            $entityManager->flush();

            return $this->redirectToRoute('attend_index');
        }

        return $this->render('attend/new.html.twig', [
            'attend' => $attend,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="attend_show", methods={"GET"})
     */
    public function show(Attend $attend): Response
    {
        return $this->render('attend/show.html.twig', [
            'attend' => $attend,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="attend_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Attend $attend): Response
    {
        $form = $this->createForm(AttendType::class, $attend);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('attend_index', [
                'id' => $attend->getId(),
            ]);
        }

        return $this->render('attend/edit.html.twig', [
            'attend' => $attend,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="attend_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Attend $attend): Response
    {
        if ($this->isCsrfTokenValid('delete'.$attend->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($attend);
            $entityManager->flush();
        }

        return $this->redirectToRoute('attend_index');
    }
}
