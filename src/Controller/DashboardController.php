<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Entity\User;
use App\Entity\Event;

class DashboardController extends AbstractController
{
    /**
     * @Route("/dashboard", name="dashboard")
     */
    public function index()
    {
        $events = $this->getDoctrine()->getRepository(Event::class)->findall();
        return $this->render('dashboard/index.html.twig', [
            'controller_name' => 'DashboardController',
            'events' => $events
        ]);
    }
}
