<?php

namespace App\Controller;

use App\Entity\Ad;
use App\Repository\AdRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AdController extends AbstractController
{
    /**
     * @Route("/ads", name="ads_index")
     */
    public function index(AdRepository $repo, SessionInterface $session)
    {   
        // $repo = $this -> getDoctrine() -> getRepository(Ad::class);
        dump($session);
        $ads = $repo -> findAll()
;
        return $this->render('ad/index.html.twig', [
            'ads' => $ads
        ]);
    }

    /**
     * Permet d'afficher une annonce
     * 
     * @Route("/ads/{slug}", name="ads_show")
     * 
     * @return Response
     */
    public function show(AdRepository $repo, $slug)
    {
        // Récupération l'annonce qui correspond au slug !
        $ad = $repo -> findOneBySlug($slug);

        return $this -> render('ad/show.html.twig', [
            'ad' => $ad
        ]);
    }
}
