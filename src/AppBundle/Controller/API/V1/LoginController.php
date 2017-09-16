<?php

namespace AppBundle\Controller\API\V1;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use AppBundle\Module\Contract\API\Response as ResponseContract;
use AppBundle\Module\Contract\API\Validator as ValidatorContract;

/**
 * Login API Controller
 *
 * @package AppBundle\Controller\API\V1
 */
class LoginController extends Controller
{

    /**
     * @var ResponseContract
     */
    protected $response;

    /**
     * @var ValidatorContract
     */
    protected $validator;

    /**
     * Class Constructor
     *
     * @param ResponseContract  $response
     * @param ValidatorContract $validator
     */
    public function __construct(ResponseContract $response, ValidatorContract $validator)
    {
        $this->response = $response;
        $this->validator = $validator;
    }

    /**
     * Auth API Action
     *
     * @Route("/api/v1/auth", name="api_v1_login_controller_auth_action")
     * @Method({"POST"})
     */
    public function authAction(Request $request)
    {
        #
    }


    /**
     * Get Current Access Token for User Using Refresh Token
     *
     * @Route("/api/v1/access_token", name="api_v1_login_controller_access_token_action")
     * @Method({"GET"})
     */
    public function accessTokenAction(Request $request)
    {
        #
    }

    /**
     * Get Current Refresh Token
     *
     * @Route("/api/v1/refresh_token", name="api_v1_login_controller_refresh_token_action")
     * @Method({"GET"})
     */
    public function refreshTokenAction(Request $request)
    {
        #
    }
}
