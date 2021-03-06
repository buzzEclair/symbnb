<?php

namespace App\Controller;

use App\Entity\Ad;
use App\Entity\User;
use App\Entity\Booking;
use App\Entity\Comment;
use App\Form\AccountType;
use App\Form\CommentType;
use App\Entity\PasswordUpdate;
use App\Form\RegistrationType;
use App\Form\PasswordUpdateType;
use Symfony\Component\Form\FormError;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class AccountController extends AbstractController
{
    /**
     * @Route("/login", name="account_login")
     */
    public function login(AuthenticationUtils $utils)
    {
        $error = $utils->getLastAuthenticationError();
        $username = $utils->getLastUsername();

        return $this->render('account/login.html.twig', [
            'hasError' => $error !== null,
            'username' => $username
        ]);
    }

    /**
     * @Route("/logout", name="account_logout")
     *
     * @return void
     */
    public function logout(){

    }

    /**
     * @Route("/register", name="account_register")
     *
     * @return void
     */
    public function register(Request $request, ObjectManager $manager,UserPasswordEncoderInterface $encoder){

        $user = new User();

        $form = $this->createForm(RegistrationType::class, $user);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $hash = $encoder->encodePassword($user, $user->getHash());
            $user->setHash($hash);
            $manager->persist($user);
            $manager->flush();

            $this->addFlash(
                'success', "Votre compte a bien été enregistré"
            );

            return $this->redirectToRoute('account_login');
        }

        return $this->render('account/registration.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/profile/edit", name="account_profile")
     *
     * @return Response
     */
    public function editUser(Request $request, ObjectManager $manager){

        $user = $this->getUser();

        $form = $this->createForm(AccountType::class, $user);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $manager->persist($user);
            $manager->flush();

            $this->addFlash(
                'success',
                'Votre profil a bien été modifié'
            );

            return $this->redirectToRoute('account_index');
        }
        
        return $this->render('account/edit.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/account/update-password", name="account_update_password")
     *
     * @return Response
     */
    public function updatePassword(Request $request, UserPasswordEncoderInterface $encoder, ObjectManager $manager){

        $passwordUpdate = new PasswordUpdate();

        $user = $this->getUser();

        $form = $this->createForm(PasswordUpdateType::class, $passwordUpdate);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            if(!password_verify($passwordUpdate->getOldPassword(), $user->getHash())){
                $form->get('oldPassword')->addError(new FormError("Le mot de pas actuel est incorrect"));
            }else {
                $newPassword = $passwordUpdate->getNewPassword();
                $hash = $encoder->encodePassword($user, $newPassword);

                $user->setHash($hash);
                $manager->persist($user);
                $manager->flush();

                $this->addFlash(
                    'success',
                    "Votre mot de passse a bien été modifié !"
                );

                return $this->redirectToRoute('homepage');
            }
           
        }

        return $this->render('account/updatePassword.html.twig', [
            'form' => $form->createView(),
            'user' => $user
        ]);
    }

    /**
     * @Route("/account", name="account_index")
     *
     * @return Response
     */
    public function myAccount(){
        return $this->render('user/index.html.twig',[
            'user' => $this->getUser()
        ]);
    }

    /**
     * @Route("/account/bookings", name="account_bookings")
     *
     * @return Response
     */
    public function bookings(){
        return $this->render('account/bookings.html.twig');
    }

    /**
     * @Route("/account/bookings/{id}/comment", name="account_bookings_comment")
     *
     * @return Response
     */
    public function bookingsComment(Booking $booking, Request $request, ObjectManager $manager){


        $comment = new Comment();

        $form = $this->createForm(CommentType::class, $comment);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $comment->setAd($booking->getAd())
                ->setAuthor($booking->getBooker())
                ->setCreatedAt(new \DateTime('now'));

            $manager->persist($comment);
            $manager->flush($comment);

            return $this->redirectToRoute('ads_show', ['slug' => $booking->getAd()->getSlug()]);

            
        }

        return $this->render('account/bookingsComment.html.twig', [
            'form' => $form->createView()
        ]);
    }
}
