<?php

namespace App\Controller;

use App\Entity\ModelPrize;
use App\Form\NewModelPrizeType;
use App\Repository\ModelPrizeRepository;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class PrizeController extends AbstractController
{
    /**
     * @Route("/manage/model", name="manageModel_page")
     */
    public function manageModel(ModelPrizeRepository $model, Request $request)
    {
        $models = $model->findAll();

        if($request->request->get("newmodel")) {
            return $this->redirectToRoute("newModel_page");
        }

        return $this->render('prize/manageModel.html.twig', [
            'models' => $models,
        ]);
    }

    /**
     * @Route("/new/model", name="newModel_page")
     */
    public function newModel(Request $request, ObjectManager $manager)
    {
        $model = new ModelPrize();

        $form = $this->createForm(NewModelPrizeType::class, $model);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            $manager->persist($model);
            $manager->flush();

            return $this->redirectToRoute('manageModel_page');
        }

        return $this->render('prize/createModel.html.twig', [
            'form' => $form->CreateView()
        ]);
    }
}
