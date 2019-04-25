<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

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
     * @Route("/admin/dashboard/ads", name="admin_ads" )
     *
     * @return void
     */
    public function adminAnnonces(){

        return $this->render('admin_ad/adminAd.html.twig', [

        ]);
    }
}
