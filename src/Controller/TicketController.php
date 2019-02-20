<?php

namespace App\Controller;

use App\Entity\Prize;
use App\Entity\User;
use App\Entity\Ticket;
use App\Repository\TicketRepository;
use App\Repository\UserRepository;
use Doctrine\Common\Persistence\ObjectManager;
use phpDocumentor\Reflection\Types\Mixed_;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class TicketController extends AbstractController
{
    /**
     * @Route("/tirages/{id}/jouer", name="playPrize_page")
     */
    public function playPrize(Prize $prize, ObjectManager $manager, Request $request, TicketRepository $tickets)
    {
        $user = $this->getUser();

        // Récupère le nombre de joueur sur le lot
        $currentPlayer = array_values($tickets->getDifferentUsers($prize->getId()) [0]);
        $prize->nombreJoueur($currentPlayer);

        // récupère le nombre de ticket joués par l'utilisateur
        $ticketUserPlay = $request->request->get('result');

        // Si des tickets sont joués
        if($ticketUserPlay != 0)
        {
            // Retire les tickets joués par l'utilisateur
            $deductionUserticket = $user->getTickets() - $ticketUserPlay;
            $user->setTickets($deductionUserticket);
            // Ajoute le nombre de ticket joué par l'utilisateur au lot selectionné
            $ajoutTicket = $prize->getCurrentTicket() + $ticketUserPlay;
            $prize->setCurrentTicket($ajoutTicket);

            // boucle qui créé le nombre de ticket joué par l'utilisateur
            for($i = 0; $i <= $ticketUserPlay -1 ; $i++)
            {
                $ticket = new Ticket();
                $ticket->setUser($user);
                $ticket->setPrize($prize);
                $ticket->setNumber();

                $manager->persist($ticket);
                $manager->flush();
            }
            $manager->persist($prize);
            $manager->persist($user);
            $manager->flush();

            // Tirage au sort du gagnant du lot quand celui-ci atteint le nombre de ticket maximal
            if($prize->getCurrentTicket() == $prize->getGoal() && $prize->getVisible() == 1)
            {
                $collectTickets = $tickets->findBy(array('prize' => $prize->getId()));
                $randWinnerTicket = array_rand($collectTickets, 1);
                $winner = $tickets->find($randWinnerTicket)->getUser()->getUsername();

                $prize->setWinner($winner);
                $prize->setVisible('0');
                $manager->persist($prize);
                $manager->flush();

                return $this->redirectToRoute('showPrize_page');
            }

            return $this->redirectToRoute('showPrize_page');
        }

        return $this->render('ticket/playPrize.html.twig', [
            'prize' => $prize
        ]);
    }

    /**
     * @Route("/profile/ticket", name="earnTicket_page")
     */
    public function earnTicket()
    {
        return $this->render('ticket/earnTicket.html.twig');
    }
}
