<?php

namespace App\Controller;

use App\Repository\AdRepository;
use App\Repository\UserRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class HomeController extends Controller {

    /**
     * @Route("/", name="homepage")
     */
    public function home(AdRepository $adRepo, UserRepository $userRepo){
        // $ads = $repo -> findAll();
        // return $this->render(
        //     "home.html.twig", 
        //     [ 
        //         'ads' => $ads
        //     ]
        //);
        return $this -> render (
            'home.html.twig',
            [
                'ads' => $adRepo -> findBestAds(3),
                'users' => $userRepo -> findBestUsers(4)
            ]
            );
    }

}

?>