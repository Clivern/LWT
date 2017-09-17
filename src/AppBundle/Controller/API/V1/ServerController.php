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

/**
 * Server API Controller
 *
 * @package AppBundle\Controller\API\V1
 */
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
        // Make sure that user owns this server
        if( !$this->server->userOwns($this->auth->getCurrentUser()->getId(), $request->get('id', '')) ){
            $this->response->setStatus(false);
            $this->response->setMessage(['type' => 'error', 'message' => $this->get('translator')->trans('Invalid Request.')]);
            return new JsonResponse($this->response->getResponse());
        }

        // Get Server
        $server = $this->server->getById($request->get('id', ''));

        if( !empty($server) ){
            // Return server data
            $this->response->setStatus(true);
            $this->response->setPayload([
                'id' => $server->getId(),
                'asset_id' => $server->getAssetId(),
                'name' => $server->getName(),
                'brand' => $server->getBrand(),
                'price' => $server->getPrice()
            ]);
            return new JsonResponse($this->response->getResponse());
        }

        // Server not exist
        $this->response->setStatus(false);
        $this->response->setMessage(['type' => 'error', 'message' => $this->get('translator')->trans('Server not exist!')]);
        return new JsonResponse($this->response->getResponse());
    }

    /**
     * Get A list of Servers
     *
     * @Route("/api/v1/server", name="api_v1_server_controller_get_many_action")
     * @Method({"GET"})
     */
    public function getManyAction(Request $request)
    {
        // Get Servers
        $servers = $this->server->getByUserId($this->auth->getCurrentUser()->getId(), 1, 100, true);
        $this->response->setStatus(true);
        $this->response->setPayload($servers, true);
        return new JsonResponse($this->response->getResponse());
    }

    /**
     * Create a new Server
     *
     * @Route("/api/v1/server", name="api_v1_server_controller_create_action")
     * @Method({"POST"})
     */
    public function createAction(Request $request)
    {
        // Validate Inputs
        $this->validator->setInputs([
            [
                'value' => $request->get('name', ''),
                'rule' => 'NotBlank',
                'constraint' => ['message' => $this->get('translator')->trans('Server name must be provided.')]
            ],[
                'value' => $request->get('name', ''),
                'rule' => 'Length',
                'parameters' => ['min' => 2, 'max' => 20],
                'constraint' => ['minMessage' => $this->get('translator')->trans('Server name must be at least 2 characters long.'), 'maxMessage' => $this->get('translator')->trans('Server name cannot be longer than 20 characters.')]
            ],[
                'value' => $request->get('name', ''),
                'rule' => 'Type',
                'parameters' => ['type' => 'alnum'],
                'constraint' => ['message' => $this->get('translator')->trans('Server name must be alphanumeric.')]
            ],


            [
                'value' => $request->get('brand', ''),
                'rule' => 'NotBlank',
                'constraint' => ['message' => $this->get('translator')->trans('Server brand must be provided.')]
            ],[
                'value' => $request->get('brand', ''),
                'rule' => 'Length',
                'parameters' => ['min' => 2, 'max' => 20],
                'constraint' => ['minMessage' => $this->get('translator')->trans('Server brand must be at least 2 characters long.'), 'maxMessage' => $this->get('translator')->trans('Server brand cannot be longer than 20 characters.')]
            ],[
                'value' => $request->get('brand', ''),
                'rule' => 'Type',
                'parameters' => ['type' => 'alnum'],
                'constraint' => ['message' => $this->get('translator')->trans('Server brand must be alphanumeric.')]
            ],

            [
                'value' => $request->get('asset_id', ''),
                'rule' => 'NotBlank',
                'constraint' => ['message' => $this->get('translator')->trans('Server asset id must be provided.')]
            ],[
                'value' => $request->get('asset_id', ''),
                'rule' => 'Length',
                'parameters' => ['min' => 1, 'max' => 11],
                'constraint' => ['minMessage' => $this->get('translator')->trans('Server asset id must be at least 1 integers long.'), 'maxMessage' => $this->get('translator')->trans('Server asset id cannot be longer than 11 integers.')]
            ],[
                'value' => $request->get('asset_id', ''),
                'rule' => 'Type',
                'parameters' => ['type' => 'numeric'],
                'constraint' => ['message' => $this->get('translator')->trans('Server asset id must be integer.')]
            ],[
                'value' => $request->get('asset_id', ''),
                'rule' => 'GreaterThan',
                'parameters' => ['value' => 0],
                'constraint' => ['message' => $this->get('translator')->trans('Server asset id must be greater than zero.')]
            ],

            [
                'value' => $request->get('price', ''),
                'rule' => 'NotBlank',
                'constraint' => ['message' => $this->get('translator')->trans('Server price must be provided.')]
            ],[
                'value' => $request->get('price', ''),
                'rule' => 'Length',
                'parameters' => ['min' => 1, 'max' => 11],
                'constraint' => ['minMessage' => $this->get('translator')->trans('Server price must be at least 1 integers long.'), 'maxMessage' => $this->get('translator')->trans('Server asset id cannot be longer than 11 integers.')]
            ],[
                'value' => $request->get('price', ''),
                'rule' => 'Type',
                'parameters' => ['type' => 'numeric'],
                'constraint' => ['message' => $this->get('translator')->trans('Server price must be a valid integer.')]
            ],[
                'value' => $request->get('price', ''),
                'rule' => 'GreaterThan',
                'parameters' => ['value' => 0],
                'constraint' => ['message' => $this->get('translator')->trans('Server price must be greater than zero.')]
            ]
        ]);

        if( !$this->validator->validate() ){
            $this->response->setStatus(false);
            $this->response->setMessages($this->validator->getMessages());
            return new JsonResponse($this->response->getResponse());
        }

        // Check if asset id is used
        if( $this->server->checkAssetId($request->get('asset_id', '')) ){
            $this->response->setStatus(false);
            $this->response->setMessage(['type' => 'error', 'message' => $this->get('translator')->trans('Asset Id is already used.')]);
            return new JsonResponse($this->response->getResponse());
        }

        // Insert Server
        $status = $this->server->insert([
            'asset_id' => $request->get('asset_id', ''),
            'user' => $this->auth->getCurrentUser(),
            'name' => $request->get('name', ''),
            'brand' => $request->get('brand', ''),
            'price' => $request->get('price', '')
        ]);

        if( $status ){
            $this->response->setStatus(true);
            $this->response->setMessage(['type' => 'success', 'message' => $this->get('translator')->trans('Server saved successfully.')]);
        }else{
            $this->response->setStatus(false);
            $this->response->setMessage(['type' => 'error', 'message' => $this->get('translator')->trans('Oops! Something goes wrong.')]);
        }

        return new JsonResponse($this->response->getResponse());
    }

    /**
     * Delete a Server
     *
     * @Route("/api/v1/server/{id}", name="api_v1_server_controller_delete_action")
     * @Method({"DELETE"})
     */
    public function deleteAction(Request $request)
    {
        // Make sure that user owns this server
        if( !$this->server->userOwns($this->auth->getCurrentUser()->getId(), $request->get('id', '')) ){
            $this->response->setStatus(false);
            $this->response->setMessage(['type' => 'error', 'message' => $this->get('translator')->trans('Invalid Request.')]);
            return new JsonResponse($this->response->getResponse());
        }

        // Delete Server
        $status = $this->server->deleteById($request->get('id', ''));

        if( $status ){
            $this->response->setStatus(true);
            $this->response->setMessage(['type' => 'success', 'message' => $this->get('translator')->trans('Server deleted successfully.')]);
        }else{
            $this->response->setStatus(false);
            $this->response->setMessage(['type' => 'error', 'message' => $this->get('translator')->trans('Oops! Something goes wrong.')]);
        }

        return new JsonResponse($this->response->getResponse());
    }
}
