<?php

namespace AppBundle\Controller\API\V1;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class ServerController extends Controller
{
	public function __construct()
	{
		#
	}

    /**
     * Get Server By ID
     *
     * @Route("/api/v1/server/{id}", requirements={"id": "\d+"}, name="api_v1_server_controller_get_one_action")
     * @Method({"GET"})
     */
    public function getOneAction(Request $request)
    {
    	#
    }

    /**
     * Get A list of Servers
     *
     * @Route("/api/v1/server", name="api_v1_server_controller_get_many_action")
     * @Method({"GET"})
     */
    public function getManyAction(Request $request)
    {
        #
    }

    /**
     * Create a new Server
     *
     * @Route("/api/v1/server", name="api_v1_server_controller_create_action")
     * @Method({"POST"})
     */
    public function createAction(Request $request)
    {
        #
    }

    /**
     * Delete a Server
     *
     * @Route("/api/v1/server/{id}", name="api_v1_server_controller_delete_action")
     * @Method({"DELETE"})
     */
    public function deleteAction(Request $request)
    {
        #
    }
}
