<?php

namespace App\Controller;

use App\Entity\User;
use App\Repository\PrizeRepository;
use App\Repository\TicketRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class MainController extends AbstractController
{
    /**
     * @Route("/", name="main_page")
     */
    public function index()
    {
        return $this->render('main/index.html.twig', [
            'controller_name' => 'MainController',
        ]);
    }

    /**
     * @Route("/infos", name="infos_page")
     */
    public function infos()
    {
        return $this->render('main/infos.html.twig', [
            'controller_name' => 'MainController',
        ]);
    }

    /**
     * @Route("/tirages", name="showPrize_page")
     */
    public function showPrize(PrizeRepository $prize, TicketRepository $ticket)
    {
        $prizes = $prize->findAll();
        $tickets = $ticket->findAll();
        return $this->render('main/showPrize.html.twig', [
            'prizes' => $prizes,
            'tickets' => $tickets
        ]);
    }
}
