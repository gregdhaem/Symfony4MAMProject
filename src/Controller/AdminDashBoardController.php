<?php

namespace App\Controller;

use App\Repository\AdRepository;
use App\Repository\UserRepository;
use App\Repository\ImageRepository;
use App\Repository\BookingRepository;
use App\Repository\CommentRepository;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AdminDashBoardController extends AbstractController
{
    /**
     * @Route("admin/dash_board", name="admin_dashboard_index")
     */
    public function index(AdRepository $adrepo,
                            BookingRepository $bookrepo,
                            CommentRepository $commentrepo,
                            ImageRepository $imgrepo,
                            UserRepository $userrepo)
    {   
        $ads = $adrepo -> findAll();
        $bookings = $bookrepo -> findAll();
        $comments = $commentrepo -> findAll();
        $images = $imgrepo -> findAll();
        $users = $userrepo -> findAll();



        return $this->render('admin/dash_board/index.html.twig', [
            'ads' => $ads,
            'bookings' => $bookings,
            'comments' => $comments,
            'images' => $images,
            'users' => $users
        ]);
    }
}
