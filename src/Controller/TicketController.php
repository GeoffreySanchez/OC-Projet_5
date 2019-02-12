<?php

namespace App\Controller;

use App\Entity\Prize;
use App\Entity\User;
use App\Entity\Ticket;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class TicketController extends AbstractController
{
    /**
     * @Route("/tirages/{id}/jouer", name="playPrize_page")
     */
    public function playPrize(Prize $prize, ObjectManager $manager, Request $request)
    {
        $user = $this->getUser();
        $ticketUserPlay = $request->request->get('result');
        if($ticketUserPlay != 0)
        {
            $deductionUserticket = $user->getTickets() - $ticketUserPlay;
            $ajoutTicket = $prize->getCurrentTicket() + $ticketUserPlay;
            $prize->setCurrentTicket($ajoutTicket);
            $user->setTickets($deductionUserticket);

            for($i = 0; $i <= $ticketUserPlay -1 ; $i++)
            {
                $ticket = new Ticket();
                $ticket->setUsernameId($user->getId());
                $ticket->setPrizeId($prize->getId());
                $ticket->setNumber();

                $manager->persist($ticket);
                $manager->flush();
            }

            $manager->persist($prize);
            $manager->persist($user);
            $manager->flush();

            return $this->redirectToRoute('showPrize_page');
        }
        // A COMPLETER POUR REDIRIGER SUR LA PAGE DU TIRAGE DU GAGNANT
        if($prize->getCurrentTicket() == $prize->getGoal())
        {
            //return $this->redirectToRoute('');
        }
        return $this->render('ticket/playPrize.html.twig', [
            'prize' => $prize
        ]);
    }
}
