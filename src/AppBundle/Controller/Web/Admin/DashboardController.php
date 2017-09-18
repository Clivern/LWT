<?php

namespace AppBundle\Controller\Web\Admin;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Module\Contract\Core\Config as ConfigContract;
use AppBundle\Module\Contract\Core\Auth as AuthContract;

/**
 * Dashboard Controller
 *
 * @package AppBundle\Controller\Web\Admin
 */
class DashboardController extends Controller
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
     * Render Dashboard
     *
     * @Route("/admin/dashboard", name="web_dashboard_controller_dashboard")
     */
    public function dashboardAction(Request $request)
    {
        return $this->render('admin/dashboard.html.twig', [
            'site_title' => $this->get('translator')->trans('Dashboard')  . " | " . $this->config->getByKey('_site_title', 'LWT'),
            'current_user' => $this->auth->getCurrentUser()
        ]);
    }
}
