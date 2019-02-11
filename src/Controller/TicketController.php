<?php

namespace App\Controller;

use App\Entity\Prize;
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
        return $this->render('ticket/playPrize.html.twig', [
            'prize' => $prize
        ]);
    }
}
