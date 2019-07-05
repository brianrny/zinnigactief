<?php

namespace App\Controller;

use App\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class OverviewController extends AbstractController
{
    /**
     * @Route("/overview", name="overview")
     */
    public function index()
    {
        //$em = $this->getDoctrine ()->getManager ();
        $checkTime = new \DateTime("now");
        $checkTime->modify('- 10 minutes');

        $repository = $this->getDoctrine()
            ->getRepository(User::class);

        $query = $repository->createQueryBuilder('p')
            ->where('p.lastActivityAt > :checkTime')
            ->setParameter('checkTime', $checkTime)
            ->getQuery();

        $logs = $query->getResult();

        return $this->render('overview/index.html.twig', [
            'controller_name' => 'OverviewController',
            'logs' => $logs,
        ]);
    }
}
