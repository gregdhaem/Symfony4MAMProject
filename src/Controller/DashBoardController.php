<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class DashBoardController extends AbstractController
{
    /**
     * @Route("admin/dash_board", name="admin_dashboard_index")
     */
    public function index()
    {
        return $this->render('admin/dash_board/index.html.twig', [
            'controller_name' => 'DashBoardController',
        ]);
    }
}
