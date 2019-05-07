<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class AdController extends AbstractController
{
    /**
     * @Route("/ads", name="ads_index")
     */
    public function index()
    {
        $repo = $this->getDoctrine()->getRepository(Ad::class);

        return $this->render('ad/index.html.twig', [
            'controller_name' => 'AdController',
        ]);
    }
}