<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\RegistrationType;
use App\Form\ProfilModificationType;
use App\Repository\UserRepository;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;


class SecurityController extends AbstractController
{
    /**
     * @Route("/inscription", name="inscription_page")
     */
    public function registration(Request $request, ObjectManager $manager, UserPasswordEncoderInterface $encoder) {
        $user = new User();

        $form = $this->createForm(RegistrationType::class, $user);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            $hash = $encoder->encodePassword($user, $user->getPassword());

            $user->setPassword($hash);

            $manager->persist($user);
            $manager->flush();

            return $this->redirectToRoute('login_page');
        }

        return $this->render('security/registration.html.twig', [
            'form' => $form->CreateView()
        ]);
        return $this->render('security/registration.html.twig', [
            'controller_name' => 'SecurityController',
        ]);
    }

    /**
     * @Route("/connexion", name="login_page")
     */
    public function login() {
        return $this->render('security/login.html.twig');
    }

    /**
     * @Route("/deconnexion", name="logout_page")
     */
    public function logout() {
    }

    /**
     * @Route("/profile", name="user_page")
     */
    public function profile() {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        $user = $this->getUser();
        return $this->render('security/profile.html.twig', [
            'user' => $user
        ]);
    }

    /**
     * @Route("/profile/modification", name="profileModification_page")
     * @Route("/profile/modification/adresse", name="profileModificationAdresse_page")
     * @Route("/profile/modification/mail", name="profileModificationEmail_page")
     * @Route("/profile/modification/password", name="profileModificationPassword_page")
     */
    public function profileModification(Request $request, UserPasswordEncoderInterface $encoder, ObjectManager $manager) {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        $CurrentUser = $this->getUser();

        if($request->isMethod("post")) {
            if ($request->get("annulerModif")) {
                return $this->redirectToRoute('profileModification_page');
            }
            elseif($request->get("modifAdresse")) {
                $CurrentUser->setAdresse($request->get("modifAdresse"));
            }
            elseif($request->get("modifEmail")) {
                if($request->get("modifEmail") == $request->get("confirmModifEmail")) {
                    $CurrentUser->setEmail($request->get("modifEmail"));
                }
                else {
                    //faire la vérification avec confirm_email
                }
            }
            elseif($request->get("modifPassword")) {
                if($request->get("modifPassword") == $request->get("confirmModifPassword")) {
                    $hash = $encoder->encodePassword($CurrentUser, $request->get("modifPassword"));
                    $CurrentUser->setPassword($hash);
                }
                else {
                    //faire la vérification avec confirm_email
                }
            }
            $manager->persist($CurrentUser);
            $manager->flush();
            return $this->render('security/profileModification.html.twig');
        }

        return $this->render('security/profileModification.html.twig');
    }

    /**
     * @Route("/admin", name="admin_page")
     */
    public function admin() {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        return $this->render('security/admin.html.twig');
    }

    /**
     * @Route("/admin/user", name="adminUser_page")
     */
    public function adminUser(UserRepository $repo) {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        $users = $repo->findAll();

        return $this->render('security/adminUser.html.twig', [
            'users' => $users
        ]);
    }

    /**
     * @Route("/promote/{id}", name="upgradeToAdmin_page")
     */
    public function ModifyRole(User $user, UserRepository $repo, ObjectManager $manager, Request $request) {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        $users = $repo->findAll();

        if($request->isMethod("post")) {
            if ($request->get("valid")) {
                dump($user);
                $user->setActive(1);
                $user->setRoles("ROLE_USER");
            }
            elseif ($request->get("upToAdmin")) {
                $user->setRoles("ROLE_ADMIN");
            }
            elseif($request->get("ban")) {
                $user->setActive(0);
                $user->setRoles("ROLE_VISITOR");
            }
            elseif($request->get("downToUser")) {
                $user->setRoles("ROLE_USER");
            }
            $manager->persist($user);
            $manager->flush();
        }

        return $this->render('security/adminUser.html.twig', [
            'users' => $users,
            'id' => $users
        ]);
    }

}
