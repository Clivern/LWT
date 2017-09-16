<?php

namespace AppBundle\EventSubscriber\API\Security;

use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Symfony\Component\HttpKernel\Event\FilterControllerEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\KernelEvents;
use AppBundle\Module\Contract\API\Response as ResponseContract;
use Symfony\Component\HttpFoundation\JsonResponse;

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
     * Class Constructor
     *
     * @param ResponseContract $response
     */
    public function __construct(ResponseContract $response)
    {
        $this->response = $response;
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

        if( (strpos($target_action, 'AppBundle\Controller\API') === false) ){
            return;
        }

        // Bypass auth action
        if( (strpos($target_action, 'LoginController@authAction') !== false) ){
            return;
        }

        $access_token = $event->getRequest()->query->get('api_token');

        if( !$access_token || ($access_token != 'Access') ){
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