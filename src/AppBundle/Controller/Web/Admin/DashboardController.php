<?php

namespace AppBundle\Controller\Web\Admin;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class DashboardController extends Controller
{
    /**
     * Render Dashboard
     *
     * @Route("/admin/dashboard", name="web_dashboard_controller_dashboard")
     */
    public function dashboardAction(Request $request)
    {
        return $this->render('admin/dashboard.html.twig');
    }
}
