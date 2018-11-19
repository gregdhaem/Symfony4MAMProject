<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class HomeController extends Controller {

    /**
     * @Route("/hello/{prenom}/age/{age}", name="hello")
     * @Route("/hello", name="hello_base")
     * @Route("/hello/{prenom}", name="hello_prenom")
     *
     * Montre la page qui dit bonjour
     * 
     * @return void
     */
    public function hello($prenom = "anonyme", $age = ".") {
        return $this->render(
            'hello.html.twig',
            [
                'prenom' => $prenom,
                'age' => $age
            ]
        );
    }

    /**
     * @Route("/", name="homepage")
     */
    public function home(){
        $prenoms =['Raphaël' => 10, 'Emilien' => 9, 'Kevin' => 14, 'Greg' => 58];
        return $this->render(
            "home.html.twig", 
            [ 
                'age' => 11,
                'title' => "Bonjour à toutes",
                'tableau' => $prenoms 
            ]
        );
    }
}

?>