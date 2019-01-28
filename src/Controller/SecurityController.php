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
     */
    public function profileModification(Request $request, ObjectManager $manager) {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        $user = $this->getUser();
        $form = $this->createForm(ProfilModificationType::class, $user);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()) {
            $manager->persist($user);
            $manager->flush();

            return $this->redirectToRoute('profileModification_page');
        }

        return $this->render('security/profileModification.html.twig', [
            'form' => $form->CreateView()
        ]);

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

        if( $request->isMethod("post")) {
            if ($request->get("valid")) {
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
