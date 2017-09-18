<?php

namespace AppBundle\Controller\Web\Admin;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Module\Contract\Core\Config as ConfigContract;
use AppBundle\Module\Contract\Core\Auth as AuthContract;
use AppBundle\Module\Contract\Core\Server as ServerContract;
use AppBundle\Module\Contract\Core\Server\Ram as RamContract;

/**
 * Server Controller
 *
 * @package AppBundle\Controller\Web\Admin
 */
class ServerController extends Controller
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
     * @var ServerContract
     */
    protected $server;

    /**
     * Class Constructor
     *
     * @param ConfigContract $config
     * @param AuthContract   $auth
     * @param ServerContract   $server
     * @param RamContract   $ram
     */
    public function __construct(ConfigContract $config, AuthContract $auth, ServerContract $server, RamContract $ram)
    {
        $this->config = $config;
        $this->auth = $auth;
        $this->server = $server;
        $this->ram = $ram;
    }

    /**
     * Render Server List
     *
     * @Route("/admin/servers", name="web_server_controller_list")
     */
    public function listAction(Request $request)
    {
        return $this->render('admin/server-list.html.twig', [
            'site_title' => $this->config->getByKey('_site_title', 'LWT'),
            'current_user' => $this->auth->getCurrentUser()
        ]);
    }

    /**
     * Render Add Server
     *
     * @Route("/admin/servers/add", name="web_server_controller_add")
     */
    public function addAction(Request $request)
    {
        return $this->render('admin/server-add.html.twig', [
            'site_title' => $this->config->getByKey('_site_title', 'LWT'),
            'current_user' => $this->auth->getCurrentUser()
        ]);
    }

    /**
     * Render Server Single
     *
     * @Route("/admin/servers/{id}/view", requirements={"id": "\d+"}, name="web_server_controller_view")
     */
    public function viewAction(Request $request)
    {
        return $this->render('admin/server-view.html.twig', [
            'site_title' => $this->config->getByKey('_site_title', 'LWT'),
            'current_user' => $this->auth->getCurrentUser()
        ]);
    }
}
