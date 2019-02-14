<?php

namespace App\Controller;

use App\Entity\Comment;
use App\Form\AdminCommentType;
use App\Service\PaginationService;
use App\Repository\CommentRepository;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AdminCommentController extends AbstractController
{
    /**
     * @Route("/admin/comments/{page<\d+>?1}", name="admin_comments_index")
     */
    public function index(CommentRepository $repo, $page, PaginationService $pagination)
    {
        $pagination -> setEntityClass(Comment::class)
                    -> setLimit(5)
                    -> setPage($page);

        return $this->render('admin/comment/index.html.twig', [
            'pagination' => $pagination,
        ]);
    }

    /**
     * Affiche le formulaire d'édition
     * 
     * @Route("/admin/comments/{id}/edit/", name="admin_comments_edit")
     * 
     * @param Request $request
     * @param Comment $comment
     * @param ObjectManager $manager
     * @return Response
     */
    public function edit(Comment $comment, Request $request, ObjectManager $manager)
    {
        $form = $this -> createForm(AdminCommentType::class, $comment);

        $form -> handleRequest($request);

        if($form -> isSubmitted() && $form -> isValid()) {

            $manager -> persist($comment);
            $manager -> flush(); 
            
            $this -> addFlash(
                "success",
                "Commentaire<strong> {$comment -> getId()} </strong> enregistrée"
            );

        }

        return $this-> render('admin/comment/edit.html.twig',
        [
            'comment' => $comment,
            'form' => $form -> createView()
        ]);
    }

    /**
     * supprimer un commentaire
     * 
     * @Route("/admin/comments/{id}/delete", name="admin_comments_delete")
     * 
     * @param Comment $comment
     * @param ObjectManager $manager
     * @return Response
     */
    public function delete(Comment $comment, ObjectManager $manager) {

        $deletedId = $comment -> getId();
        $manager -> remove($comment);
        $manager -> flush();

        $this -> addFlash(
            "success",
            "Commentaire <strong> {$deletedId} </strong> supprimé"
        );
        
        return $this -> redirectToRoute('admin_comments_index');
    }
}
