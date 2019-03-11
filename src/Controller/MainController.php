<?php

namespace App\Controller;

use App\Repository\PrizeRepository;
use App\Repository\TicketRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class MainController extends AbstractController
{
    /**
     * @Route("/", name="main_page")
     * @Route("/tirages", name="showEndedPrize_page")
     */
    public function showPrize(EntityManagerInterface $manager, PrizeRepository $prize, TicketRepository $ticket, Request $request)
    {
        $route = $request->attributes->get('_route');
        $prizes = $prize->findAll();
        $tickets = $ticket->findAll();

        foreach ($prizes as $prize) {
            $prize->endPrize();
            $currentPlayer = array_values($ticket->getDifferentUsers($prize->getId()) [0]);
            $prize->nombreJoueur($currentPlayer);

            $manager->flush();
        }
        $view = ($route == 'showEndedPrize_page') ? 'showEndedPrize' : 'index';
        return $this->render('main/' . $view . '.html.twig', [
            'prizes' => $prizes,
            'tickets' => $tickets
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
}
