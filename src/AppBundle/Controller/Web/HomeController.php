<?php

namespace AppBundle\Controller\Web;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Module\Contract\Core\Config as ConfigContract;
use AppBundle\Module\Contract\Core\Auth as AuthContract;

class HomeController extends Controller
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
     * Render Homepage
     *
     * @Route("/", name="web_home_controller_homepage")
     */
    public function homeAction(Request $request)
    {
        return $this->render('guest/home.html.twig', [
            'site_title' => 'LWT'
        ]);
    }
}