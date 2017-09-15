<?php

namespace AppBundle\Controller\API\V1\Server;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class RamController extends Controller
{
    public function __construct()
    {
        #
    }

    /**
     * Get Server Ram By ID
     *
     * @Route("/api/v1/server/{server_id}/ram/{ram_id}", requirements={"server_id": "\d+", "ram_id": "\d+"}, name="api_v1_server_ram_controller_get_one_action")
     * @Method({"GET"})
     */
    public function getOneAction(Request $request)
    {
        #
    }

    /**
     * Get A list of Rams for specific Server
     *
     * @Route("/api/v1/server/{server_id}/ram", requirements={"server_id": "\d+"}, name="api_v1_server_ram_controller_get_many_action")
     * @Method({"GET"})
     */
    public function getManyAction(Request $request)
    {
        #
    }

    /**
     * Create a new Ram
     *
     * @Route("/api/v1/server/{server_id}/ram", requirements={"server_id": "\d+"}, name="api_v1_server_ram_controller_create_action")
     * @Method({"POST"})
     */
    public function createAction(Request $request)
    {
        #
    }

    /**
     * Delete a Ram
     *
     * @Route("/api/v1/server/{server_id}/ram/{ram_id}", requirements={"server_id": "\d+", "ram_id": "\d+"}, name="api_v1_server_ram_controller_delete_action")
     * @Method({"DELETE"})
     */
    public function deleteAction(Request $request)
    {
        #
    }
}
