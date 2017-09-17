<?php

namespace AppBundle\EventSubscriber\API\Security;

use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Symfony\Component\HttpKernel\Event\FilterControllerEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Component\HttpFoundation\JsonResponse;
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
     * Class Constructor
     *
     * @param ResponseContract $response
     */
    public function __construct(ResponseContract $response, AuthContract $auth)
    {
        $this->response = $response;
        $this->auth = $auth;
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

        // Bypass auth action
        if( (strpos($target_action, 'LoginController@authAction') !== false) ){
            $this->auth->isLogged();
            return;
        }

        if( (strpos($target_action, 'AppBundle\Controller\API') === false) ){
            $this->auth->isLogged();
            return;
        }

        $access_token = $event->getRequest()->query->get('api_token');

        if( empty($access_token) ){
            $access_token = $event->getRequest()->headers->get('X-AUTH-TOKEN');
        }

        if( empty($access_token) ){
            $this->response->setStatus(false);
            $this->response->setMessage(['type' => 'error', 'message' => 'Access Denied! Access Token Not Provided.']);
            echo json_encode($this->response->getResponse());
            die();
        }

        $user = $this->auth->getUserByApiToken($access_token);

        if( empty($user) ){
            $this->response->setStatus(false);
            $this->response->setMessage(['type' => 'error', 'message' => 'Access Denied! Invalid or Expired Access Token.']);
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