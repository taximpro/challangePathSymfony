<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

class SecurityController extends AbstractController
{
    /**
     * @Route("/login", name="login")
     */
    public function login(Request $request, AuthenticationUtils $utils)
    {
        /*
         *
         * if ($this->getUser()) {
            if( in_array('ROLE_ADMIN', $this->getUser()->getRoles() ) ):
                return $this->redirectToRoute('backend_home');
            elseif ( in_array('ROLE_VENDOR', $this->getUser()->getRoles() ) ):
                return $this->redirectToRoute('frontend_account_vendor_dashboard');
            elseif ( in_array('ROLE_CUSTOMER', $this->getUser()->getRoles() ) ):
                return $this->redirectToRoute('frontend_account_history');
            else:
                return $this->redirectToRoute('frontend_home');
            endif;
        */

        if ($this->getUser()) {
            return $this->redirectToRoute('dashboard');
        }



        $error = $utils->getLastAuthenticationError();
        $lastUsername = $utils->getLastUsername();
        return $this->render('security/login.html.twig', [
            'error' => $error,
            'last_username' => $lastUsername,
        ]);
    }

    /**
     * @Route("/logout", name="logout")
     */
    public function logout(){

    }
}
