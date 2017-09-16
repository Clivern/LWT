<?php

namespace AppBundle\Controller\API\V1\Server;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use AppBundle\Module\Contract\API\Response as ResponseContract;
use AppBundle\Module\Contract\API\Validator as ValidatorContract;
use AppBundle\Module\Contract\Core\Server\Ram as RamContract;
use AppBundle\Module\Contract\Core\Config as ConfigContract;
use AppBundle\Module\Contract\Core\Auth as AuthContract;

class RamController extends Controller
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
     * @var RamContract
     */
    protected $ram;

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
     * @param RamContract    $server
     * @param ConfigContract    $config
     * @param AuthContract    $auth
     */
    public function __construct(ResponseContract $response, ValidatorContract $validator, RamContract $ram, ConfigContract $config, AuthContract $auth)
    {
        $this->response = $response;
        $this->validator = $validator;
        $this->ram = $ram;
        $this->config = $config;
        $this->auth = $auth;
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
