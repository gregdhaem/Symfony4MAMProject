<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\AccountType;
use App\Entity\PasswordUpdate;
use App\Form\RegistrationType;
use App\Form\PasswordUpdateType;
use Symfony\Component\Form\FormError;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class AccountController extends AbstractController
{
    /**
     * Permet d'afficher le formulaire de connexion
     * 
     * @Route("/login", name="account_login")
     * 
     * @return Response
     */
    public function login(AuthenticationUtils $utils)
    {
        $error = $utils -> getLastAuthenticationError();
        $username = $utils -> getLastUsername();
        

        return $this->render('account/login.html.twig', [
            'hasError' => $error !== null,
            'username' => $username
        ]);
    }


    /**
     * Permet de se déconnecter
     * 
     * @route("/logout", name="account_logout")
     * 
     * @return void
     */
    public function logout() 
    {

    }

    /**
     * Afficher le formaulaire d'inscription
     * 
     * @route("/register", name="account_register")
     * 
     * @return Response  
     */
    public function register(Request $request, ObjectManager $manager, UserPasswordEncoderInterface $encoder)
    {
        $user = new User();

        $form = $this -> createForm(RegistrationType::class, $user);

        $form -> handleRequest($request);

        if($form -> isSubmitted() && $form -> isValid()) 
        {
            $hash = $encoder -> encodePassword($user, $user -> getHash());

            $user -> setHash($hash);

            $manager -> persist($user);
            $manager -> flush();

            $this -> addFlash(
                'success',
                "Votre compte a bien été créé avec succès, vous pouvez maintenant vous connecter !"
            );

            return $this -> redirectToRoute('account_login');
        }
        return $this -> render('account/registration.html.twig', [
            'form' => $form -> createView()
        ]);

    }


    /**
     * Permet d'afficher le profil pour modification
     * 
     * @Route("/account/profile", name="account_profile")
     * 
     * @return Response
     */
    public function profile(Request $request, ObjectManager $manager) {
        $user = $this -> getUser();

        $form = $this -> createForm(AccountType::class, $user);

        $form -> handleRequest($request);

        if($form -> isSubmitted() && $form -> isValid()) {

            $manager -> persist($user);
            $manager -> flush();

            $this -> addFlash(
                'success',
                'Les modifications ont été enregistrées'
            );
        }
 
        return $this -> render('account/profile.html.twig', [
            'form' => $form -> createView()
        ]);
    }

    /**
     * Permet de modifier les mots de passe utilisateur
     * 
     * @Route("/account/password-update", name="account_password")
     *  
     * @return Response
     */
    public function updatePassword(Request $request, UserPasswordEncoderInterface $encoder, ObjectManager $manager) {
        $passwordUpdate = new PasswordUpdate();

        $user = $this -> getUser();

        $form = $this -> createForm(PasswordUpdateType::class, $passwordUpdate);

        $form -> handleRequest($request);

        if($form -> isSubmitted() && $form -> isValid()) {

            if(!password_verify($passwordUpdate -> getOldPassword(), $user -> getHash())) {

                $form -> get('oldPassword') -> addError(new FormError("Veuillez indiquer votre ancien mot de passe"));

            } else {
                $newPassword = $passwordUpdate -> getNewPassword();
                $hash = $encoder -> encodePassword($user, $newPassword);

                $user -> setHash($hash);

                $manager -> persist($user);
                $manager -> flush();

                $this -> addFlash(
                    'success',
                    'Les modifications du mot de passe ont été enregistrées'
                );

                return $this -> redirectToRoute('ads_index');
            };
        }

        return $this -> render('account/password.html.twig', [
            'form' => $form -> createView()
        ]);
    }

    /**
     * Affichage du profil de l'utilisateur connecté
     * 
     * @Route("/account", name="account_index")
     * 
     * @return Response
     */
    public function myAccount() {
        return $this -> render('user/index.html.twig', [
            'user' => $this -> getUser()
        ]);
    }
}
