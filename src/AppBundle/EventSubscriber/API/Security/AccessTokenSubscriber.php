<?php

namespace AppBundle\EventSubscriber\API\Security;

use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Symfony\Component\HttpKernel\Event\FilterControllerEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Security\Csrf\CsrfTokenManagerInterface;
use AppBundle\Module\Contract\API\Response as ResponseContract;
use AppBundle\Module\Contract\Core\Auth as AuthContract;

/**
 * Check for Access Token on API Requests
 *
 * @package AppBundle\EventSubscriber\API\Security
 */
class AccessTokenSubscriber implements EventSubscriberInterface
{

    /**
     * @var ResponseContract
     */
    protected $response;

    /**
     * @var AuthContract
     */
    protected $auth;

    /**
     * @var CsrfTokenManagerInterface
     */
    protected $token_manager;

    /**
     * Class Constructor
     *
     * @param ResponseContract $response
     */
    public function __construct(ResponseContract $response, AuthContract $auth, CsrfTokenManagerInterface $token_manager)
    {
        $this->response = $response;
        $this->auth = $auth;
        $this->token_manager = $token_manager;
    }

    /**
     * Action to run before controller
     *
     * @param  FilterControllerEvent $event
     * @return void
     */
    public function onKernelController(FilterControllerEvent $event)
    {
        $controller = $event->getController();

        if (!is_array($controller)) {
            return;
        }

        if( !isset($controller[0]) || !isset($controller[0]) ){
            return;
        }

        $target_action = get_class($controller[0]) . '@' . $controller[1];


        // Check For CSRF Token in case of Ajax Request
        if( $event->getRequest()->isXmlHttpRequest() && (strpos($target_action, 'ProfilerController@toolbarAction') === false) ){
            $csrf_token = $event->getRequest()->query->get('csrf_token');
            if( !$csrf_token ){
                $csrf_token = $event->getRequest()->request->get('csrf_token');
            }
            if( $csrf_token != $this->token_manager->getToken('intention')->getValue() ){
                $this->response->setStatus(false);
                $this->response->setMessage(['type' => 'error', 'message' => 'Invalid Request!']);
                echo json_encode($this->response->getResponse());
                die();
            }
        }

        // Bypass auth action from the api token verification
        if( (strpos($target_action, 'LoginController@authAction') !== false) ){
            $this->auth->isLogged();
            return;
        }

        // Bypass All web controllers from api token verification
        if( (strpos($target_action, 'AppBundle\Controller\API') === false) ){
            $this->auth->isLogged();
            return;
        }

        // Get API access token from url parameters
        $access_token = $event->getRequest()->query->get('api_token');

        // Get API token from header
        if( empty($access_token) ){
            $access_token = $event->getRequest()->headers->get('X-AUTH-TOKEN');
        }

        // Check if API Token exists
        if( empty($access_token) ){
            $this->response->setStatus(false);
            $this->response->setMessage(['type' => 'error', 'message' => 'Access Denied! Access Token Not Provided.']);
            echo json_encode($this->response->getResponse());
            die();
        }

        // Load User Data in auth object with his access token
        $user = $this->auth->getUserByApiToken($access_token);
        if( empty($user) ){
            $this->response->setStatus(false);
            $this->response->setMessage(['type' => 'error', 'message' => 'Access Denied! Invalid or Expired Access Token.']);
            echo json_encode($this->response->getResponse());
            die();
        }

        // Check if token expired
        if( (time() > $user->getApiTokenExpire()) && (strpos($target_action, 'LoginController@accessTokenAction') === false) && (strpos($target_action, 'LoginController@refreshTokenAction') === false) ){
            $this->response->setStatus(false);
            $this->response->setMessage(['type' => 'error', 'message' => 'Access Denied! Expired Access Token.']);
            echo json_encode($this->response->getResponse());
            die();
        }
    }

    /**
     * Get Subscribed Events
     *
     * @return array
     */
    public static function getSubscribedEvents()
    {
        return [
            KernelEvents::CONTROLLER => 'onKernelController',
        ];
    }
}