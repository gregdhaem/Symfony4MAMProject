<?php

namespace App\Controller;

use App\Entity\Ad;
use App\Form\AdType;
use App\Repository\AdRepository;
use App\Service\PaginationService;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AdminAdController extends AbstractController
{   
    // @Route("/admin/ads/{page}", name="admin_ads_index", requirements={"page": "\d+"})
    // @Route("/admin/ads/{page<\d+>?1}" 
    /**
     * @Route("/admin/ads/{page<\d+>?1}", name="admin_ads_index")
     */
    public function index(AdRepository $repo, $page, PaginationService $pagination)
    {

        $pagination -> setEntityClass(Ad::class)
                    -> setPage($page);

        $ads = $pagination -> getData();

        $total = count($repo -> findAll());

        $pages = ceil($total / 10);


        return $this->render('admin/ad/index.html.twig', [
            'ads' => $ads,
            'pages' => $pages,
            'page' => $page
        ]);
    }

    /**
     * Affiche le formulaire d'édition
     * 
     * @Route("/admin/ads/{id}/edit/", name="admin_ads_edit")
     * 
     * @param Request $request
     * @param Ad $ad
     * @return Response
     */
    public function edit(Ad $ad, Request $request, ObjectManager $manager)
    {
        $form = $this -> createForm(AdType::class, $ad);

        $form -> handleRequest($request);

        if($form -> isSubmitted() && $form -> isValid()) {

//            foreach($ad -> getImages() as $image) {
//                $image -> setAd($ad);
//                $manager -> persist($image);
//           }

            $manager -> persist($ad);
            $manager -> flush(); 
            
            $this -> addFlash(
                "success",
                "Annonce <strong>{$ad -> getTitle()}</strong> enregistrée"
            );

        }

        return $this-> render('admin/ad/edit.html.twig',
        [
            'ad' => $ad,
            'form' => $form -> createView()
        ]);
    }

    /**
     * supprimer une annonce
     * 
     * @Route("/admin/ads/{id}/delete", name="admin_ads_delete")
     * 
     * @param Ad $ad
     * @param ObjectManager $manager
     * @return Response
     */
    public function delete(Ad $ad, ObjectManager $manager) {
        if(count($ad -> getBookings()) > 0) {
            $this -> addFlash(
                "warning",
                "Annonce <strong>{$ad -> getTitle()}</strong> possède des réservations et ne peut être supprimée"
            );
        
        } else {
            $manager -> remove($ad);
            $manager -> flush();
    
            $this -> addFlash(
                "success",
                "Annonce <strong>{$ad -> getTitle()}</strong> supprimée"
            );
        }
        return $this -> redirectToRoute('admin_ads_index');
    }
}



