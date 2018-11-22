<?php

namespace App\Controller;

use App\Entity\Ad;
use App\Form\AdType;
use App\Entity\Image;
use App\Repository\AdRepository;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
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
        // dump($session);
        $ads = $repo -> findAll()
;
        return $this->render('ad/index.html.twig', [
            'ads' => $ads
        ]);
    }

    /**
     * Permet de créer une annonce
     * 
     * @Route("/ads/new", name="ads_create")
     * 
     * @return Response 
     */
    public function create(Request $request, ObjectManager $manager)
    {   
        $ad = new Ad();

        $form = $this -> createForm(AdType::class, $ad);

        $form -> handleRequest($request);

        dump($ad);



        if($form -> isSubmitted() && $form -> isValid())
        {
            $manager -> persist($ad);
            $manager -> flush();
            
            $this -> addFlash(
                'success',
                "L'annonce <strong>{$ad -> getTitle()}</strong> a bien été enregistrée !"
            );

            return $this -> redirectToRoute('ads_show', [
                'slug' => $ad -> getSlug()
            ]);
        }

        return $this -> render('ad/new.html.twig', [
            'form' => $form -> createView()
        ]);
    }

    /**
     * Permet d'afficher une annonce
     * 
     * @Route("/ads/{slug}", name="ads_show")
     * 
     * @return Response
     */
    public function show(Ad $ad) // Param Converter
    {
        // Récupération l'annonce qui correspond au slug !
        // $ad = $repo -> findOneBySlug($slug);
        return $this -> render('ad/show.html.twig', [
            'ad' => $ad
        ]);
    }

}
