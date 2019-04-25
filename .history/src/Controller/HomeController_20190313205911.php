<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use App\Repository\AdRepository;

class HomeController extends Controller{
    
    /**
     * Fonction Page Home
     * 
     * @Route("/", name="homepage")
     * 
     * @return Response
     */
    public function home(AdRepository $repo){



        return $this->render(
            'home.html.twig',
            [
                'ad' => $ad
            ]
        );
    }
}

?>