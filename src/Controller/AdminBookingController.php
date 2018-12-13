<?php

namespace App\Controller;

use App\Entity\Booking;
use App\Repository\BookingRepository;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AdminBookingController extends AbstractController
{
    /**
     * @Route("/admin/bookings", name="admin_bookings_index")
     */
    public function index(BookingRepository $repo)
    {
        return $this->render('admin/booking/index.html.twig', [
            'controller_name' => 'AdminBookingController',
            'bookings' => $repo -> findAll()
        ]);
    }


    /**
     * Permet d'afficher une réservation
     * 
     * @Route("/admin/bookings/{id}", name="admin_bookings_show")
     * 
     * @return Response
     */
    public function show(Booking $booking) {
        return $this -> render('admin/booking/show.html.twig', [
            'booking' => $booking
        ]);
    }
}
