<?php

namespace App\Controller;

use App\Entity\Ad;
use App\Entity\User;
use App\Form\AdsType;
use App\Repository\AdRepository;
use App\Repository\UserRepository;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Form\AccountType;

class AdminAdController extends AbstractController
{
    /**
     * @Route("/admin/dashboard", name="admin_dashboard")
     */
    public function index()
    {
        return $this->render('admin_ad/index.html.twig', [
            'controller_name' => 'AdminAdController',
        ]);
    }

    /**
     * @Route("/admin/dashboard/ads", name="admin_ads")
     *
     * @return Response
     */
    public function adminAnnonces(AdRepository $repo){

        $ads = $repo->findAll();

        return $this->render('admin_ad/adminAd.html.twig', [
            'ads' => $ads
        ]);
    }

    /**
     * @Route("/admin/dashboard/ads/{slug}/edit", name="admin_ads_edit")
     *
     * @return Response
     */
    public function adminAnnoncesEdit(Request $request,Ad $ad,ObjectManager $manager){

        $form = $this->createForm(AdsType::class, $ad);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){

            foreach($ad->getImages() as $image){
                $image->setAd($ad);
                $manager->persist($image);
            }

            $manager->persist($ad);
            $manager->flush();

            $this->addFlash(
                'success',
                "L'annonce <strong>{$ad->getTitle()}</strong> a bien été modifiée !"
            );

            return $this->redirectToRoute('ads_show', [
                'slug' => $ad->getSlug()
            ]);
        }

        return $this->render('admin_ad/editAd.html.twig', [
            'form' => $form->createView(),
            'ad' => $ad
        ]);
    }


    /**
     * @Route("/admin/dashboard/users", name="admin_users")
     *
     * @return Response
     */
    public function adminUsers(UserRepository $repo){

        $users = $repo->findAll();

        return $this->render('admin_ad/adminUsers.html.twig', [
            'users' => $users
        ]);
    }
    
    /**
     * @Route("/admin/dashboard/user/{slug}/edit", name="admin_user_edit")
     *
     * @return Response
     */
    public function editUser(Request $request, ObjectManager $manager, User $user){

        $form = $this->createForm(AccountType::class, $user);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $manager->persist($user);
            $manager->flush();

            $this->addFlash(
                'success',
                'Votre profil a bien été modifié'
            );

            return $this->redirectToRoute('account_profile');
        }
        
        return $this->render('admin_ad/editUser.html.twig', [
            'form' => $form->createView(),
            'user' => $user
        ]);
    }

    /**
     * @Route("/admin/dashboard/user/{id}/delete", name="admin_user_delete")
     *
     * @return Response
     */
    public function deleteUser(ObjectManager $manager, UserRepository $repo, $id){

        $user = $repo->find($id);

        $manager->remove($user);
        $manager->flush();

        return $this->redirectToRoute('admin_users');
    }

    /**
     * @Route("/admin/dashboard/ad/{id}/delete", name="admin_ad_delete")
     *
     * @return Response
     */
    public function deleteAd(ObjectManager $manager, AdRepository $repo, $id){

        $ad = $repo->find($id);

        $manager->remove($ad);
        $manager->flush();

        return $this->redirectToRoute('admin_ads');
    }
}
