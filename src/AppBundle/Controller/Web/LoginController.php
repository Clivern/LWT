<?php

namespace AppBundle\Controller\Web;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class LoginController extends Controller
{
    /**
     * Render Login
     *
     * @Route("/login", name="web_login_controller_login")
     */
    public function loginAction(Request $request)
    {
        return $this->render('guest/login.html.twig');
    }

    /**
     * Logout Action
     *
     * @Route("/logout", name="web_login_controller_logout")
     */
    public function logoutAction(Request $request)
    {
        #
    }
}
