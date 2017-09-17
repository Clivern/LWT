<?php

namespace AppBundle\Controller\API\V1;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use AppBundle\Module\Contract\API\Response as ResponseContract;
use AppBundle\Module\Contract\API\Validator as ValidatorContract;
use AppBundle\Module\Contract\Core\User as UserContract;
use AppBundle\Module\Contract\Core\Config as ConfigContract;
use AppBundle\Module\Contract\Core\Auth as AuthContract;

/**
 * User API Controller
 *
 * @package AppBundle\Controller\API\V1
 */
class UserController extends Controller
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
     * @var UserContract
     */
    protected $user;

    /**
     * @var ConfigContract
     */
    protected $config;

    /**
     * @var AuthContract
     */
    protected $auth;

    /**
     * Class Constructor
     *
     * @param ResponseContract  $response
     * @param ValidatorContract $validator
     * @param UserContract      $user
     * @param ConfigContract    $config
     * @param AuthContract      $auth
     */
    public function __construct(ResponseContract $response, ValidatorContract $validator, UserContract $user, ConfigContract $config, AuthContract $auth)
    {
        $this->response = $response;
        $this->validator = $validator;
        $this->user = $user;
        $this->config = $config;
        $this->auth = $auth;
    }

    /**
     * @Route("/api/user/{id}", requirements={"id": "\d+"}, name="api_v1_user_controller_update_action")
     * @Method({"PUT"})
     */
    public function updateAction(Request $request)
    {
        // Make sure that request come from profile owner
        if( $this->auth->getCurrentUser()->getId() != $request->get('id') ){
            $this->response->setStatus(false);
            $this->response->setMessage(['type' => 'error', 'message' => $this->get('translator')->trans('Invalid Request.')]);
            return new JsonResponse($this->response->getResponse());
        }

        // Validate Inputs
        $this->validator->setInputs([
            [
                'value' => $request->get('name', ''),
                'rule' => 'NotBlank',
                'constraint' => ['message' => $this->get('translator')->trans('Your name must be provided.')]
            ],[
                'value' => $request->get('name', ''),
                'rule' => 'Length',
                'parameters' => ['min' => 2, 'max' => 20],
                'constraint' => ['minMessage' => $this->get('translator')->trans('Your name must be at least 2 characters long.'), 'maxMessage' => $this->get('translator')->trans('Your name cannot be longer than 20 characters.')]
            ],[
                'value' => $request->get('name', ''),
                'rule' => 'Type',
                'parameters' => ['type' => 'string'],
                'constraint' => ['message' => $this->get('translator')->trans('Your name must be a string.')]
            ],[
                'value' => $request->get('username', ''),
                'rule' => 'NotBlank',
                'constraint' => ['message' => $this->get('translator')->trans('Your username must be provided.')]
            ],[
                'value' => $request->get('username', ''),
                'rule' => 'Length',
                'parameters' => ['min' => 2, 'max' => 20],
                'constraint' => ['minMessage' => $this->get('translator')->trans('Your username must be at least 2 characters long.'), 'maxMessage' => $this->get('translator')->trans('Your username cannot be longer than 20 characters.')]
            ],[
                'value' => $request->get('username', ''),
                'rule' => 'Type',
                'parameters' => ['type' => 'alnum'],
                'constraint' => ['message' => $this->get('translator')->trans('Your username must be alphanumeric.')]
            ],[
                'value' => $request->get('email', ''),
                'rule' => 'NotBlank',
                'constraint' => ['message' => $this->get('translator')->trans('Your email must be provided.')]
            ],[
                'value' => $request->get('email', ''),
                'rule' => 'Email',
                'constraint' => ['message' => $this->get('translator')->trans('Invalid email address.')]
            ],
        ]);

        if( !$this->validator->validate() ){
            $this->response->setStatus(false);
            $this->response->setMessages($this->validator->getMessages());
            return new JsonResponse($this->response->getResponse());
        }

        // Check if Username is used
        if( $this->user->chechUsername($request->get('username'), $this->auth->getCurrentUser()->getId()) ){
            $this->response->setStatus(false);
            $this->response->setMessage(['type' => 'error', 'message' => $this->get('translator')->trans('Error! Username is already used.')]);
            return new JsonResponse($this->response->getResponse());
        }

        // Check if email is used
        if( $this->user->checkEmail($request->get('email'), $this->auth->getCurrentUser()->getId()) ){
            $this->response->setStatus(false);
            $this->response->setMessage(['type' => 'error', 'message' => $this->get('translator')->trans('Error! Email is already used.')]);
            return new JsonResponse($this->response->getResponse());
        }

        // Update Profile
        $status = $this->user->updateById($request->get('id'), [
            'name' => $request->get('name'),
            'username' => $request->get('username'),
            'email' => $request->get('email')
        ]);

        if( $status ){
            $this->response->setStatus(true);
            $this->response->setMessage(['type' => 'success', 'message' => $this->get('translator')->trans('Profile updated successfully.')]);
        }else{
            $this->response->setStatus(false);
            $this->response->setMessage(['type' => 'error', 'message' => $this->get('translator')->trans('Oops! Something goes wrong.')]);
        }

        return new JsonResponse($this->response->getResponse());
    }

}
