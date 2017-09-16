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
        #
    }

}
