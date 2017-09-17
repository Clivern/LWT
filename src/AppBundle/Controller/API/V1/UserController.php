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

        if( $this->auth->getCurrentUser()->getId() != $request->get('id') ){
            $this->response->setStatus(false);
            $this->response->setMessage(['type' => 'error', 'message' => 'Invalid Request.']);
            return new JsonResponse($this->response->getResponse());
        }

        $this->validator->setInputs([
            'name' => ['value' => $request->get('name'), 'rule' => 'Email', 'constraint' => ['message' => 'Invalid email address']],
            'username' => ['value' => $request->get('username'), 'rule' => 'Email', 'constraint' => ['message' => 'Invalid email address']],
            'email' => ['value' => $request->get('email'), 'rule' => 'Email', 'constraint' => ['message' => 'Invalid email address']],
        ]);

        if( !$this->validator->validate() ){
            $this->response->setStatus(false);
            $this->response->setMessages($this->validator->getMessages());
            return new JsonResponse($this->response->getResponse());
        }


        if( $this->user->chechUsername($request->get('username'), $this->auth->getCurrentUser()->getId()) ){
            $this->response->setStatus(false);
            $this->response->setMessage(['type' => 'error', 'message' => 'Error! Username is already used.']);
            return new JsonResponse($this->response->getResponse());
        }

        if( $this->user->checkEmail($request->get('email'), $this->auth->getCurrentUser()->getId()) ){
            $this->response->setStatus(false);
            $this->response->setMessage(['type' => 'error', 'message' => 'Error! Email is already used.']);
            return new JsonResponse($this->response->getResponse());
        }

        $status = $this->user->updateById($request->get('id'), [
            'name' => $request->get('name'),
            'username' => $request->get('username'),
            'email' => $request->get('email')
        ]);

        if( $status ){
            $this->response->setStatus(true);
            $this->response->setMessage(['type' => 'success', 'message' => 'Profile updated successfully.']);
        }else{
            $this->response->setStatus(false);
            $this->response->setMessage(['type' => 'error', 'message' => 'Oops! Something goes wrong.']);
        }

        return new JsonResponse($this->response->getResponse());
    }

}
