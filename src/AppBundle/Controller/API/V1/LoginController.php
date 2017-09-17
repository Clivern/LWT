<?php

namespace AppBundle\Controller\API\V1;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use AppBundle\Module\Contract\API\Response as ResponseContract;
use AppBundle\Module\Contract\API\Validator as ValidatorContract;
use AppBundle\Module\Contract\Core\Config as ConfigContract;
use AppBundle\Module\Contract\Core\Auth as AuthContract;
use AppBundle\Module\Contract\Core\User as UserContract;

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
     * @var ConfigContract
     */
    protected $config;

    /**
     * @var AuthContract
     */
    protected $auth;

    /**
     * @var UserContract
     */
    protected $user;

    /**
     * Class Constructor
     *
     * @param ResponseContract  $response
     * @param ValidatorContract $validator
     * @param ConfigContract $config
     * @param AuthContract $auth
     */
    public function __construct(ResponseContract $response, ValidatorContract $validator, ConfigContract $config, AuthContract $auth, UserContract $user)
    {
        $this->response = $response;
        $this->validator = $validator;
        $this->config = $config;
        $this->auth = $auth;
        $this->user = $user;
    }

    /**
     * Auth API Action
     *
     * @Route("/api/v1/auth", name="api_v1_login_controller_auth_action")
     * @Method({"POST"})
     */
    public function authAction(Request $request)
    {
        // Validate Inputs
        $this->validator->setInputs([
            [
                'value' => $request->request->get('username', ''),
                'rule' => 'NotBlank',
                'constraint' => ['message' => $this->get('translator')->trans('Username or password is invalid.')]
            ],[
                'value' => $request->request->get('username', ''),
                'rule' => 'Length',
                'parameters' => ['min' => 2, 'max' => 20],
                'constraint' => ['minMessage' => $this->get('translator')->trans('Username or password is invalid.'), 'maxMessage' => $this->get('translator')->trans('Username or password is invalid.')]
            ],[
                'value' => $request->request->get('username', ''),
                'rule' => 'Type',
                'parameters' => ['type' => 'alnum'],
                'constraint' => ['message' => $this->get('translator')->trans('Username or password is invalid.')]
            ],[
                'value' => $request->request->get('password', ''),
                'rule' => 'NotBlank',
                'constraint' => ['message' => $this->get('translator')->trans('Username or password is invalid.')]
            ],[
                'value' => $request->request->get('password', ''),
                'rule' => 'Length',
                'parameters' => ['min' => 2, 'max' => 20],
                'constraint' => ['minMessage' => $this->get('translator')->trans('Username or password is invalid'), 'maxMessage' => $this->get('translator')->trans('Username or password is invalid.')]
            ],
        ]);

        if( !$this->validator->validate() ){
            $this->response->setStatus(false);
            $this->response->setMessage(['type' => 'error', 'message' => $this->get('translator')->trans('Username or password is invalid.')]);
            return new JsonResponse($this->response->getResponse());
        }

        // Check Credentials
        if( $this->auth->checkCredentials($request->request->get('username', ''), $request->request->get('password', '')) ){
            // Login
            if( $this->auth->loginByUsername($request->request->get('username', '')) ){

                // Get User Data
                $user = $this->user->getByUsername($request->request->get('username', ''));

                // Send User Data
                $this->response->setStatus(true);
                $this->response->setPayload([
                    'id' => $user->getId(),
                    'api_token' => $user->getApiToken(),
                    'api_token_expire' => $user->getApiTokenExpire()
                ]);
                return new JsonResponse($this->response->getResponse());
            }
        }

        $this->response->setStatus(false);
        $this->response->setMessage(['type' => 'error', 'message' => $this->get('translator')->trans('Username or password is invalid.')]);
        return new JsonResponse($this->response->getResponse());
    }


    /**
     * Get Current Access Token for User Using Refresh Token
     *
     * @Route("/api/v1/api_token", name="api_v1_login_controller_access_token_action")
     * @Method({"POST"})
     */
    public function accessTokenAction(Request $request)
    {
        // Get Received token
        $received_token = $request->request->get('refresh_token', '');

        // Get site global refresh tokens
        $refresh_token = $this->config->getByKey('_api_refresh_token', false);
        $old_refresh_token = $this->config->getByKey('_api_old_refresh_token', false);

        // Check if refresh token is valid
        if( in_array($received_token, [$refresh_token, $old_refresh_token]) ){
            // Update user access token
            $this->user->updateAccessTokenById($this->auth->getCurrentUser()->getId());
            // Return current access token
            $user = $this->user->getById($this->auth->getCurrentUser()->getId());
            $this->response->setStatus(true);
            $this->response->setPayload([
                'api_token' => $user->getApiToken(),
            ]);
            return new JsonResponse($this->response->getResponse());
        }

        $this->response->setStatus(false);
        $this->response->setMessage(['type' => 'error', 'message' => $this->get('translator')->trans('Invalid Refresh Token.')]);
        return new JsonResponse($this->response->getResponse());
    }

    /**
     * Get Current Refresh Token
     *
     * @Route("/api/v1/refresh_token", name="api_v1_login_controller_refresh_token_action")
     * @Method({"GET"})
     */
    public function refreshTokenAction(Request $request)
    {
        // Check and update current refresh token
        $this->config->updateRefreshToken();
        $refresh_token = $this->config->getByKey('_api_refresh_token', false);
        if( $refresh_token ){
            // Return current refresh token
            $this->response->setStatus(true);
            $this->response->setPayload([
                'refresh_token' => $refresh_token,
            ]);
            return new JsonResponse($this->response->getResponse());
        }else{
            $this->response->setStatus(false);
            $this->response->setMessage(['type' => 'error', 'message' => $this->get('translator')->trans('Oops! Something goes wrong.')]);
            return new JsonResponse($this->response->getResponse());
        }
    }
}
