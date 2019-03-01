<?php

namespace App\Controller;

use App\Entity\User;
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

    public function index()
    {
        return $this->render('main/index.html.twig');
    }
     */
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
     * @Route("/", name="main_page")
     * @Route("/tirages", name="showEndedPrize_page")
     */
    public function showPrize(EntityManagerInterface $manager,PrizeRepository $prize, TicketRepository $ticket, Request $request)
    {
        $route = $request->attributes->get('_route');
        $prizes = $prize->findAll();
        $tickets = $ticket->findAll();

        foreach ($prizes as $prize)
        {
            $prize->endprize();
            $currentPlayer = array_values($ticket->getDifferentUsers($prize->getId()) [0]);
            $prize->nombreJoueur($currentPlayer);

            $manager->persist($prize);
            $manager->flush();
        }
        if ($route == 'showEndedPrize_page')
        {
            return $this->render('main/showEndedPrize.html.twig', [
                'prizes' => $prizes,
                'tickets' => $tickets
            ]);
        }
        else
        {
            return $this->render('main/index.html.twig', [
                'prizes' => $prizes,
                'tickets' => $tickets
            ]);
        }
    }
}
