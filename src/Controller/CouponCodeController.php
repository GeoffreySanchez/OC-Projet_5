<?php

namespace App\Controller;

use App\Entity\CouponCode;
use App\Entity\UserCode;
use App\Form\CreateCodeType;
use App\Repository\CouponCodeRepository;
use App\Repository\UserCodeRepository;
use App\Repository\VideoRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class CouponCodeController extends AbstractController
{
    /**
     * @Route("/admin/code", name="viewCouponCode_page")
     */
    public function viewCode(CouponCodeRepository $codes)
    {
        return $this->render('coupon_code/viewCouponCode.html.twig', [
            'codes' => $codes->findAll(),
        ]);
    }

    /**
     * @Route("/admin/code/new", name="newCouponCode_page")
     * @Route("/admin/code/modify/{id}", name="modifyCouponCode_page")
     */
    public function manageCouponCode(Request $request, EntityManagerInterface $manager, CouponCode $couponCode = null)
    {
        if (!$couponCode) {
            $couponCode = new CouponCode();
        }

        if ($request->request->get("action") == "deleteCode") {
            $manager->remove($couponCode);
            $manager->flush();

            return $this->redirectToRoute('viewCouponCode_page');
        }

        $form = $this->createForm(CreateCodeType::class, $couponCode);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
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
    public function useCouponCode(Request $request, EntityManagerInterface $manager, CouponCodeRepository $coupons, UserCodeRepository $UserCodes, VideoRepository $video)
    {
        $user = $this->getUser();
        $videoToWatch = $video->getRandomUrl();
        $form = $request->request->get('couponCode');

        if ($form != null) {
            if ($coupons->findBy(array('code' => $form))) {
                $usedCode = $coupons->findBy(array('code' => $form))[0];
                $currentUse = $usedCode->getCurrentUse();
                $maxUse = $usedCode->getMaxUse();
                $usable = $usedCode->getUsable();

                if ($currentUse >= $maxUse - 1) {
                    $usedCode->disableCode();
                }

                // Message d'erreur si le code n'est plus valide (trop d'utilisation)
                if ($usable == 0) {
                    $this->addFlash(
                        'usedCode',
                        'Ce code n\'est plus valide !'
                    );
                    return $this->redirectToRoute('useCouponCode_page');
                } //Si le code envoyé par l'utilisateur est déjà utilisé
                elseif ($UserCodes->findBy(array('couponCode' => $usedCode)) & $UserCodes->findBy(array('user' => $user))) {
                    $this->addFlash(
                        'usedCode',
                        'Vous avez déjà utilisé ce code !'
                    );
                    return $this->redirectToRoute('useCouponCode_page');
                } else {
                    //ajout des tickets à l'utilisateur
                    $addTickets = $user->getTickets() + $usedCode->getTicket();
                    $user->setTickets($addTickets);

                    //archivage de l'utilisation du code par l'utilisateur
                    $userCode = new UserCode();
                    $userCode->setUser($user);
                    $userCode->setCouponCode($coupons->findBy(array('code' => $form))[0]);

                    //incrémente l'utilisation du ticket
                    $usedCode->setCurrentUse($currentUse + 1);

                    $manager->persist($userCode);
                    $manager->flush();

                    $this->addFlash(
                        'unusedCode',
                        'Votre code vous a fait gagner ' . $usedCode->getTicket() . ' tickets !'
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
        return $this->render('ticket/earnTicket.html.twig', [
            'video' => $videoToWatch
        ]);
    }
}
