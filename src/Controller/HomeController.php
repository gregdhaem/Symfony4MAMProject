<?php

namespace App\Controller;

use App\Repository\AdRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class HomeController extends Controller {

    /**
     * @Route("/", name="homepage")
     */
    public function home(AdRepository $repo){
        $ads = $repo -> findAll();
        return $this->render(
            "home.html.twig", 
            [ 
                'ads' => $ads
            ]
        );
    }

}

?>