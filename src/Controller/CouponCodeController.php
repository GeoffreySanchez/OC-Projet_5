<?php

namespace App\Controller;

use App\Entity\CouponCode;
use App\Entity\User;
use App\Entity\UserCode;
use App\Form\CreateCodeType;
use App\Form\CreatePrizeType;
use App\Repository\CouponCodeRepository;
use App\Repository\UserCodeRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class CouponCodeController extends AbstractController
{
    /**
     * @Route("/admin/code", name="viewCouponCode_page")
     */
    public function viewCode(CouponCodeRepository $codes)
    {
        $allCode = $codes->findAll();
        return $this->render('coupon_code/viewCouponCode.html.twig', [
            'codes' => $allCode,
        ]);
    }

    /**
     * @Route("/admin/code/new", name="newCouponCode_page")
     * @Route("/admin/code/modify/{id}", name="modifyCouponCode_page")
     */
    public function manageCouponCode(Request $request, ObjectManager $manager, CouponCode $couponCode = null)
    {
        if(!$couponCode)
        {
            $couponCode = new CouponCode();
        }

        if($request->request->get("action") == "deleteCode")
        {
            $manager->remove($couponCode);
            $manager->flush();

            return $this->redirectToRoute('viewCouponCode_page');
        }

        $form = $this->createForm(CreateCodeType::class, $couponCode);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid())
        {
            $manager->persist($couponCode);
            $manager->flush();
            return $this->redirectToRoute('viewCouponCode_page');
        }

        return $this->render('coupon_code/createCouponCode.html.twig', [
            'form' => $form->createView(),
            'editMode' => $couponCode->getId() !== null
        ]);
    }

    /**
     * @Route("/profile/ticket/useCuponCode", name="useCouponCode_page")
     */
    public function useCouponCode(Request $request, ObjectManager $manager, CouponCodeRepository $coupons, UserCodeRepository $UserCodes)
    {
        $user = $this->getUser();
        $form = $request->request->get('couponCode');
        if ($form != null)
        {
            if ($coupons->findBy(array('code' => $form)))
            {
                $usedCode = $coupons->findBy(array('code' => $form))[0];
                $currentUse = $usedCode->getCurrentUse();

                //Si le code envoyé par l'utilisateur est déjà utilisé
                if ($UserCodes->findBy(array('couponCode' => $usedCode)) & $UserCodes->findBy(array('user' => $user)))
                {
                    $this->addFlash(
                        'usedCode',
                        'Vous avez déjà utilisé ce code !'
                    );
                    return $this->redirectToRoute('useCouponCode_page');
                }
                else
                {
                    //ajout des tickets à l'utilisateur
                    $addTickets = $user->getTickets() + $usedCode->getTicket();
                    $addTicketsToUser = $user->setTickets($addTickets);

                    //archivage de l'utilisation du code par l'utilisateur
                    $userCode = new UserCode();
                    $userCode->setUser($user);
                    $userCode->setCouponCode($coupons->findBy(array('code' => $form))[0]);

                    //incrémente l'utilisation du ticket
                    $codeUsed = $usedCode->setCurrentUse($currentUse +1);

                    $manager->persist($userCode);
                    $manager->persist($usedCode);
                    $manager->persist($user);
                    $manager->flush();

                    $this->addFlash(
                        'unusedCode',
                        'Votre code vous a fait gagner ' .$usedCode->getTicket(). ' tickets !'
                    );
                    return $this->redirectToRoute('useCouponCode_page');
                }
            }
            $this->addFlash(
                'usedCode',
                'Votre code n\'est pas valide !'
            );
            return $this->redirectToRoute('useCouponCode_page');
        }
        return $this->render('ticket/earnTicket.html.twig');
    }
}
