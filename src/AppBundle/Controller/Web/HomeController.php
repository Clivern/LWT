<?php

namespace AppBundle\Controller\Web;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class HomeController extends Controller
{
    /**
     * Render Homepage
     *
     * @Route("/", name="web_home_controller_homepage")
     */
    public function homeAction(Request $request)
    {
        return $this->render('guest/home.html.twig');
    }
}
