<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

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
    public function adminAnnonces(){
        
        return $this->render('admin_ad/adminAd.html.twig', [

        ]);
    }
}
