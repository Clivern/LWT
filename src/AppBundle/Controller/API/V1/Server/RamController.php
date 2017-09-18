<?php

namespace AppBundle\Controller\API\V1\Server;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use AppBundle\Module\Contract\API\Response as ResponseContract;
use AppBundle\Module\Contract\API\Validator as ValidatorContract;
use AppBundle\Module\Contract\Core\Server as ServerContract;
use AppBundle\Module\Contract\Core\Server\Ram as RamContract;
use AppBundle\Module\Contract\Core\Config as ConfigContract;
use AppBundle\Module\Contract\Core\Auth as AuthContract;

/**
 * Ram API Controller
 *
 * @package AppBundle\Controller\API\V1\Server
 */
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
     * @param RamContract    $server
     * @param ConfigContract    $config
     * @param AuthContract    $auth
     */
    public function __construct(ResponseContract $response, ValidatorContract $validator, RamContract $ram, ServerContract $server, ConfigContract $config, AuthContract $auth)
    {
        $this->response = $response;
        $this->validator = $validator;
        $this->ram = $ram;
        $this->server = $server;
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
        // Make sure that user owns this server
        if( !$this->server->userOwns($this->auth->getCurrentUser()->getId(), $request->attributes->get('server_id', '')) ){
            $this->response->setStatus(false);
            $this->response->setMessage(['type' => 'error', 'message' => $this->get('translator')->trans('Invalid Request.')]);
            return new JsonResponse($this->response->getResponse());
        }

        // Make sure that user owns this ram
        if( !$this->ram->userOwns($this->auth->getCurrentUser()->getId(), $request->attributes->get('ram_id', '')) ){
            $this->response->setStatus(false);
            $this->response->setMessage(['type' => 'error', 'message' => $this->get('translator')->trans('Invalid Request.')]);
            return new JsonResponse($this->response->getResponse());
        }

        // Get Ram
        $ram = $this->ram->getById($request->attributes->get('ram_id', ''));

        if( !empty($ram) ){
            // Return ram data
            $this->response->setStatus(true);
            $this->response->setPayload([
                'id' => $ram->getId(),
                'type' => $ram->getType(),
                'size' => $ram->getSize()
            ]);
            return new JsonResponse($this->response->getResponse());
        }

        // Ram Not Exist
        $this->response->setStatus(false);
        $this->response->setMessage(['type' => 'error', 'message' => $this->get('translator')->trans('Ram not exist!')]);
        return new JsonResponse($this->response->getResponse());
    }

    /**
     * Get A list of Rams for specific Server
     *
     * @Route("/api/v1/server/{server_id}/ram", requirements={"server_id": "\d+"}, name="api_v1_server_ram_controller_get_many_action")
     * @Method({"GET"})
     */
    public function getManyAction(Request $request)
    {
        // Make sure that user owns this server
        if( !$this->server->userOwns($this->auth->getCurrentUser()->getId(), $request->attributes->get('server_id', '')) ){
            $this->response->setStatus(false);
            $this->response->setMessage(['type' => 'error', 'message' => $this->get('translator')->trans('Invalid Request.')]);
            return new JsonResponse($this->response->getResponse());
        }

        // Get Rams
        $rams = $this->ram->getByServerId($request->attributes->get('server_id', ''), 1, 100, true);

        // Return Response
        $this->response->setStatus(true);
        $this->response->setPayload($rams, true);
        return new JsonResponse($this->response->getResponse());
    }

    /**
     * Create a new Ram
     *
     * @Route("/api/v1/server/{server_id}/ram", requirements={"server_id": "\d+"}, name="api_v1_server_ram_controller_create_action")
     * @Method({"POST"})
     */
    public function createAction(Request $request)
    {
        // Make sure that user owns this server
        if( !$this->server->userOwns($this->auth->getCurrentUser()->getId(), $request->attributes->get('server_id', '')) ){
            $this->response->setStatus(false);
            $this->response->setMessage(['type' => 'error', 'message' => $this->get('translator')->trans('Invalid Request.')]);
            return new JsonResponse($this->response->getResponse());
        }

        // Validate Inputs
        $this->validator->setInputs([
            [
                'value' => $request->request->get('type', ''),
                'rule' => 'NotBlank',
                'constraint' => ['message' => $this->get('translator')->trans('Ram type must be provided.')]
            ],[
                'value' => $request->request->get('type', ''),
                'rule' => 'Choice',
                'parameters' => ['DDR3', 'DDR4'],
                'constraint' => ['message' => $this->get('translator')->trans('Ram type must be DDR3 or DDR4.'), 'strict' => true]
            ],[
                'value' => $request->request->get('size', ''),
                'rule' => 'NotBlank',
                'constraint' => ['message' => $this->get('translator')->trans('Ram size must be provided.')]
            ],[
                'value' => $request->request->get('size', ''),
                'rule' => 'Length',
                'parameters' => ['min' => 1, 'max' => 11],
                'constraint' => ['minMessage' => $this->get('translator')->trans('Ram size must be at least 1 integers long.'), 'maxMessage' => $this->get('translator')->trans('Ram size cannot be longer than 11 integers.')]
            ],[
                'value' => $request->request->get('size', ''),
                'rule' => 'Type',
                'parameters' => ['type' => 'numeric'],
                'constraint' => ['message' => $this->get('translator')->trans('Ram size must be integer.')]
            ],[
                'value' => $request->request->get('size', ''),
                'rule' => 'GreaterThan',
                'parameters' => ['value' => 0],
                'constraint' => ['message' => $this->get('translator')->trans('Ram size must be greater than zero.')]
            ]
        ]);

        if( !$this->validator->validate() ){
            $this->response->setStatus(false);
            $this->response->setMessages($this->validator->getMessages());
            return new JsonResponse($this->response->getResponse());
        }

        // Insert Server Ram
        $status = $this->ram->insert([
            'server' => $this->server->getById($request->attributes->get('server_id', '')),
            'user' => $this->auth->getCurrentUser(),
            'type' => trim($request->request->get('type', '')),
            'size' => trim($request->request->get('size', ''))
        ]);

        if( $status ){
            $this->response->setStatus(true);
            $this->response->setMessage(['type' => 'success', 'message' => $this->get('translator')->trans('Ram saved successfully.')]);
        }else{
            $this->response->setStatus(false);
            $this->response->setMessage(['type' => 'error', 'message' => $this->get('translator')->trans('Oops! Something goes wrong.')]);
        }

        return new JsonResponse($this->response->getResponse());
    }

    /**
     * Delete a Ram
     *
     * @Route("/api/v1/server/{server_id}/ram/{ram_id}", requirements={"server_id": "\d+", "ram_id": "\d+"}, name="api_v1_server_ram_controller_delete_action")
     * @Method({"DELETE"})
     */
    public function deleteAction(Request $request)
    {
        // Make sure that user owns this server
        if( !$this->server->userOwns($this->auth->getCurrentUser()->getId(), $request->attributes->get('server_id', '')) ){
            $this->response->setStatus(false);
            $this->response->setMessage(['type' => 'error', 'message' => $this->get('translator')->trans('Invalid Request.')]);
            return new JsonResponse($this->response->getResponse());
        }

        // Make sure that user owns this ram
        if( !$this->ram->userOwns($this->auth->getCurrentUser()->getId(), $request->attributes->get('ram_id', '')) ){
            $this->response->setStatus(false);
            $this->response->setMessage(['type' => 'error', 'message' => $this->get('translator')->trans('Invalid Request.')]);
            return new JsonResponse($this->response->getResponse());
        }

        // Delete Ram
        $status = $this->ram->deleteById($request->attributes->get('ram_id', ''));

        if( $status ){
            $this->response->setStatus(true);
            $this->response->setMessage(['type' => 'success', 'message' => $this->get('translator')->trans('Ram deleted successfully.')]);
        }else{
            $this->response->setStatus(false);
            $this->response->setMessage(['type' => 'error', 'message' => $this->get('translator')->trans('Oops! Something goes wrong.')]);
        }

        return new JsonResponse($this->response->getResponse());
    }
}
