<?php

namespace AppBundle\Controller\API\V1;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use AppBundle\Module\Contract\API\Response as ResponseContract;
use AppBundle\Module\Contract\API\Validator as ValidatorContract;
use AppBundle\Module\Contract\Core\Server as ServerContract;
use AppBundle\Module\Contract\Core\Config as ConfigContract;
use AppBundle\Module\Contract\Core\Auth as AuthContract;

class ServerController extends Controller
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
     * @var ServerContract
     */
    protected $server;

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
     * @param ServerContract    $server
     * @param ConfigContract    $config
     * @param AuthContract      $auth
     */
    public function __construct(ResponseContract $response, ValidatorContract $validator, ServerContract $server, ConfigContract $config, AuthContract $auth)
    {
        $this->response = $response;
        $this->validator = $validator;
        $this->server = $server;
        $this->config = $config;
        $this->auth = $auth;
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
