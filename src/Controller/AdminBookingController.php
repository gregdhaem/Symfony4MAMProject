<?php

namespace App\Controller;

use App\Entity\Booking;
use App\Form\BookingType;
use App\Form\AdminBookingType;
use App\Service\PaginationService;
use App\Repository\BookingRepository;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AdminBookingController extends AbstractController
{
    /**
     * Affichage de toutes les réservations
     * 
     * @Route("/admin/bookings/{page<\d+>?1}", name="admin_bookings_index")
     */
    public function index(BookingRepository $repo, $page, PaginationService $pagination)
    {   

        $pagination -> setEntityClass(Booking::class)
                    -> setPage($page);

        return $this->render('admin/booking/index.html.twig', [
            'pagination' => $pagination
            // 'bookings' => $pagination -> getData(),
            // 'pages' => $pagination -> getPages(),
            // 'page' => $page
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

    /**
     * Permet de supprimer une réservation
     * 
     * @Route("/admin/bookings/{id}/delete", name="admin_bookings_delete")
     * 
     * @Security("is_granted('ROLE_ADMIN')",
     *  message="Vous ne pouvez pas supprimer cette réservation!")
     * 
     * @param Booking $booking
     * @param ObjectManager $manager
     * @return Response
     */
    public function delete(Booking $booking, ObjectManager $manager) {
        $bookingId = $booking -> getId();
        $bookingBooker = $booking -> getBooker() -> getFullName();
        $manager -> remove($booking);
        $manager -> flush();

        $this -> addFlash(
            'success',
            "La réservation <strong>({$bookingId})</strong> du voyageur <strong>({$bookingBooker})</strong> a bien été supprimée !"
        );

        return $this -> redirectToRoute("admin_bookings_index");
    }

    /**
     * Permet de modifier une réservation
     * 
     * @Route("/admin/bookings/{id}/edit", name="admin_bookings_edit")
     * @IsGranted("ROLE_ADMIN")
     * 
     * @return Response
     */
    public function edit(Booking $booking, Request $request, ObjectManager $manager)
    {
        $booking -> setAmount(0);
        $form = $this -> createForm(AdminBookingType::class, $booking, [
            'validation_groups' => ["Default"]
        ]);

        $form -> handleRequest($request);

        if($form -> isSubmitted() && $form -> isValid()) 
        {

            //if(!$booking -> areDatesBookable()) {

            //} else {

                $manager -> persist($booking);
                $manager -> flush();

                $this -> addFlash(
                    'warning',
                    "La réservation n° {$booking -> getId()} a été modifiée"
                );
   
                return $this -> redirectToRoute('admin_bookings_index', [
                    'id' => $booking -> getId(),
                    'withAlert' => true]);
            //}
        }
        
        return $this->render('admin/booking/edit.html.twig', [
            'booking' => $booking,
            'form' => $form -> createView()
        ]);
    }
}
