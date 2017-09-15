<?php

namespace AppBundle\Controller\Web\Admin;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class ServerController extends Controller
{
    /**
     * Render Server List
     *
     * @Route("/admin/servers", name="web_server_controller_list")
     */
    public function listAction(Request $request)
    {
        return $this->render('admin/server-list.html.twig');
    }

    /**
     * Render Add Server
     *
     * @Route("/admin/servers/add", name="web_server_controller_add")
     */
    public function addAction(Request $request)
    {
        return $this->render('admin/server-add.html.twig');
    }

    /**
     * Render Server Single
     *
     * @Route("/admin/servers/{id}/view", requirements={"id": "\d+"}, name="web_server_controller_view")
     */
    public function viewAction(Request $request)
    {
        return $this->render('admin/server-view.html.twig');
    }
}
