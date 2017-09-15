<?php

namespace AppBundle\Controller\API\V1;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class UserController extends Controller
{

	public function __construct()
	{
		#
	}

    /**
     * @Route("/api/user/{id}", requirements={"id": "\d+"}, name="api_v1_user_controller_update_action")
     * @Method({"PUT"})
     */
    public function updateAction(Request $request)
    {
    	#
    }

}
