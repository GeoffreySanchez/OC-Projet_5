<?php

namespace App\Controller;

use App\Entity\ModelPrize;
use App\Entity\Prize;
use App\Form\CreatePrizeType;
use App\Form\ModifyPrizeType;
use App\Form\NewModelPrizeType;
use App\Repository\ModelPrizeRepository;
use App\Repository\PrizeRepository;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class PrizeController extends AbstractController
{
    /**
     * @Route("admin/model", name="viewModel_page")
     */
    public function viewModel(ModelPrizeRepository $model, Request $request)
    {
        $models = $model->findAll();
        if($request->request->get("newmodel"))
        {
            return $this->redirectToRoute("newModel_page");
        }

        return $this->render('prize/viewModel.html.twig', [
            'models' => $models,
        ]);
    }

    /**
     * @Route("/admin/model/new", name="newModel_page")
     * @Route("/admin/model/modify/{id}", name="modifyModel_page")
     */
    public function manageModel(Request $request, ObjectManager $manager, ModelPrize $model = null)
    {
        if(!$model)
        {
            $model = new ModelPrize();
        }

        if($request->request->get("action") == "deleteModel")
        {
            $manager->remove($model);
            $manager->flush();

            return $this->redirectToRoute('viewModel_page');
        }

        $form = $this->createForm(NewModelPrizeType::class, $model);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid())
        {
            $manager->persist($model);
            $manager->flush();
            return $this->redirectToRoute('viewModel_page');
        }

        return $this->render('prize/createModel.html.twig', [
            'form' => $form->createView(),
            'editMode' => $model->getId() !== null
        ]);
    }

    /**
     * @Route("/admin/prize", name="viewPrize_page")
     */
    public function viewPrize(PrizeRepository $prizes)
    {
        $allPrize = $prizes->findAll();
        return $this->render('prize/viewPrize.html.twig', [
            'prizes' => $allPrize,
        ]);
    }

    /**
     * @Route("/admin/prize/new", name="createPrize_page")
     * @Route("/admin/prize/new/{id}", name="createPrizeId_page")
     */
    public function createPrize(ModelPrizeRepository $model, Request $request, ObjectManager $manager, Prize $prize = null)
    {
        $models = $model->findAll();
        $modelPick = null;

        if ($request->attributes->get('id'))
        {
            $modelPick = $model->find($request->attributes->get('id'));
        }

        if(!$prize)
        {
            $prize = new Prize();
        }

        $form = $this->createForm(CreatePrizeType::class, $prize);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid())
        {
            $prize->setEndDate(null);
            $manager->persist($prize);
            $manager->flush();
            return $this->redirectToRoute('viewPrize_page');
        }

        return $this->render('prize/createPrize.html.twig', [
            'form' => $form->createView(),
            'models' => $models,
            'modelPick' => $modelPick
        ]);
    }

    /**
     * @Route("/admin/prize/modify/{id}", name="modifyPrize_page")
     */
    public function modifyPrize(Request $request, ObjectManager $manager, Prize $prize)
    {
        $form = $this->createForm(ModifyPrizeType::class, $prize);
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid())
        {
            $manager->persist($prize);
            $manager->flush();
            return $this->redirectToRoute('viewPrize_page');
        }

        if($request->request->get('action') == 'deletePrize')
        {
            $manager->remove($prize);
            $manager->flush();
            return $this->redirectToRoute('viewPrize_page');
        }

        return $this->render('prize/modifyPrize.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
