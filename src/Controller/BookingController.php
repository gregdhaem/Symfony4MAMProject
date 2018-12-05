<?php

namespace App\Controller;

use App\Entity\Ad;
use App\Entity\Booking;
use App\Form\BookingType;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class BookingController extends AbstractController
{
    /**
     * @Route("/ads/{slug}/book", name="booking_create")
     * @IsGranted("ROLE_USER")
     */
    public function book(Ad $ad, Request $request, ObjectManager $manager)
    {
        
        $booking = new Booking();
        $form = $this -> createForm(BookingType::class, $booking);

        $form -> handleRequest($request);

        if($form -> isSubmitted() && $form -> isValid()) 
        {
            $user = $this -> getUser();

            $booking -> setBooker($user)
                    -> setAd($ad);

            if(!$booking -> areDatesBookable()) {
                $this -> addFlash(
                    'warning',
                    "Les dates que vous avez choisies ne sont pas disponibles"
                );
            } else {
                $manager -> persist($booking);
                $manager -> flush();
    
                return $this -> redirectToRoute('booking_show', [
                    'id' => $booking -> getId(),
                    'withAlert' => true]);
            }
        }
        
        return $this->render('booking/book.html.twig', [
            'ad' => $ad,
            'form' => $form -> createView()
        ]);
    }


    /**
     * Permet d'afficher la page d'une résa
     * 
     * @Route("/booking/{id}", name="booking_show")
     * 
     */
    public function show(Booking $booking) {
        return $this -> render('booking/show.html.twig', [
            'booking' => $booking
        ]);
    }
}