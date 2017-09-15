<?php

namespace AppBundle\Controller\Web\Admin;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class ProfileController extends Controller
{
    /**
     * Render Server List
     *
     * @Route("/admin/profile", name="web_profile_controller_update")
     */
    public function updateAction(Request $request)
    {
        return $this->render('admin/profile.html.twig');
    }
}
