<?php

namespace OrderEntry\Bundle\AdminBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use FOS\UserBundle\Model\UserInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Security;

/**
 * Class SecurityController
 * @package OrderEntry\Bundle\AdminBundle\Controller
 */
class SecurityController extends Controller
{
    /**
     * @Route("/login", name=""admin_login)
     * @Template()
     */
    public function loginAction(Request $request)
    {

//        if ($this->get('security.authorization_checker')->isGranted('ROLE_ADMIN')) {
//            return $this->redirect($this->generateUrl(''));
//        }
    }    
}
