<?php

namespace App\Controller;

use App\Entity\Video;
use App\Form\NewVideoType;
use App\Repository\VideoRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class VideoController extends AbstractController
{
    /**
     * @Route("admin/video", name="viewVideo_page")
     */
    public function viewVideo(Request $request, VideoRepository $video)
    {
        $videos = $video->findAll();
        if($request->request->get("newVideo"))
        {
            return $this->redirectToRoute("newVideo_page");
        }

        return $this->render('video/viewVideo.html.twig', [
            'videos' => $videos,
        ]);
    }

    /**
     * @Route("/admin/video/new", name="newVideo_page")
     * @Route("/admin/video/modify/{id}", name="modifyVideo_page")
     */
    public function manageVideo(Request $request, EntityManagerInterface $manager, Video $video = null)
    {
        if(!$video)
        {
            $video = new Video();
        }

        if($request->request->get("action") == "deleteVideo")
        {
            $manager->remove($video);
            $manager->flush();

            return $this->redirectToRoute('viewVideo_page');
        }

        $form = $this->createForm(NewVideoType::class, $video);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid())
        {
            $manager->persist($video);
            $manager->flush();
            return $this->redirectToRoute('viewVideo_page');
        }

        return $this->render('video/createVideo.html.twig', [
            'form' => $form->createView(),
            'editMode' => $video->getId() !== null
        ]);
    }
}
