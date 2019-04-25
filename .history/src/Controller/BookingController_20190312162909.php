<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Ad;
use App\Form\BookingType;

class BookingController extends AbstractController
{
    /**
     * @Route("/ads/{slug}/book", name="booking_create")
     */
    public function book(Ad $ad)
    {

        $form = $this->createForm(BookingType::class)

        return $this->render('booking/book.html.twig', [
           'ad' => $ad,
           'form' => $form
        ]);
    }
}
