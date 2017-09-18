<?php

namespace AppBundle\Controller\Web;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Module\Contract\Core\Config as ConfigContract;
use AppBundle\Module\Contract\Core\Auth as AuthContract;

/**
 * Login Controller
 *
 * @package AppBundle\Controller\Web
 */
class LoginController extends Controller
{

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
     * @param ConfigContract $config
     * @param AuthContract   $auth
     */
    public function __construct(ConfigContract $config, AuthContract $auth)
    {
        $this->config = $config;
        $this->auth = $auth;
    }

    /**
     * Render Login
     *
     * @Route("/login", name="web_login_controller_login")
     */
    public function loginAction(Request $request)
    {
        // Check if user logged in
        if( !empty($this->auth->getCurrentUser()) ){
            // Send to dashboard
            return $this->redirectToRoute('web_dashboard_controller_dashboard');
        }

        return $this->render('guest/login.html.twig',[
            'site_title' => $this->config->getByKey('_site_title', 'LWT'),
            'current_user' => $this->auth->getCurrentUser()
        ]);
    }

    /**
     * Logout Action
     *
     * @Route("/logout", name="web_login_controller_logout")
     */
    public function logoutAction(Request $request)
    {
        #
    }
}
