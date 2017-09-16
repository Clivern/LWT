<?php

namespace AppBundle\Controller\Web;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

use AppBundle\Module\Contract\Core\Config as ConfigContract;

class HomeController extends Controller
{

    /**
     * @var ConfigContract
     */
    protected $config_service;

    public function __construct(ConfigContract $config_service)
    {
        $this->config_service = $config_service;
    }

    /**
     * Render Homepage
     *
     * @Route("/", name="web_home_controller_homepage")
     */
    public function homeAction(Request $request)
    {
        return $this->render('guest/home.html.twig', [
            'site_title' => $this->config_service->getByKey('_site_title')
        ]);
    }
}