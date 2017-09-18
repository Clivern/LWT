<?php

namespace AppBundle\Controller\Web\Admin;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Module\Contract\Core\Config as ConfigContract;
use AppBundle\Module\Contract\Core\Auth as AuthContract;
use AppBundle\Module\Contract\Core\User as UserContract;

/**
 * Profile Controller
 *
 * @package AppBundle\Controller\Web\Admin
 */
class ProfileController extends Controller
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
     * @var UserContract
     */
    protected $user;

    /**
     * Class Constructor
     *
     * @param ConfigContract $config
     * @param AuthContract   $auth
     * @param UserContract   $user
     */
    public function __construct(ConfigContract $config, AuthContract $auth, UserContract $user)
    {
        $this->config = $config;
        $this->auth = $auth;
        $this->user = $user;
    }

    /**
     * Render Server List
     *
     * @Route("/admin/profile", name="web_profile_controller_update")
     */
    public function updateAction(Request $request)
    {
        return $this->render('admin/profile.html.twig', [
            'site_title' => $this->get('translator')->trans('Profile')  . " | " . $this->config->getByKey('_site_title', 'LWT'),
            'current_user' => $this->auth->getCurrentUser()
        ]);
    }
}
