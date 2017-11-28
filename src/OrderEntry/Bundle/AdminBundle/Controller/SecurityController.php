<?php

namespace OrderEntry\Bundle\AdminBundle\Controller;

use OrderEntry\Bundle\AdminBundle\Entity\Admin;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use FOS\UserBundle\Model\UserInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Security;
use OrderEntry\Bundle\AdminBundle\Form\Type\AdminLoginFormType;
use Symfony\Component\Security\Core\Authorization\AuthorizationCheckerInterface;

/**
 * Class SecurityController
 * @package OrderEntry\Bundle\AdminBundle\Controller
 */
class SecurityController extends Controller
{
    /** @var AuthorizationCheckerInterface $authorizationChecker */
    private $authorizationChecker;


    public function __construct(AuthorizationCheckerInterface $authorizationChecker)
    {
        $this->authorizationChecker = $authorizationChecker;
    }

    /**
     * @Route("/login", name="admin_login")
     * @Template()
     */
    public function loginAction(Request $request)
    {

        if ($this->authorizationChecker->isGranted('ROLE_ADMIN')) {
            return $this->redirect($this->generateUrl('orderentry_admin_default_index'));
        }

        $session = $request->getSession();
        if ($request->attributes->has(Security::AUTHENTICATION_ERROR)) {
            $error = $request->attributes->get(Security::AUTHENTICATION_ERROR);
        } elseif(null !== $session && $session->has(Security::AUTHENTICATION_ERROR)) {
            $error = $session->get(Security::AUTHENTICATION_ERROR);
            $session->remove(Security::AUTHENTICATION_ERROR);
        } else {
            $error = null;
        }

        $form = $this->createForm(AdminLoginFormType::class);

        return[
          'error' => $error,
          'form' => $form->createView(),
        ];
    }

    /**
     * @Route("/login_check", name="admin_login_check")
     */
    public function checkAction()
    {
        throw new \RuntimeException('You must configure the check path to be handled by the firewall using form_login in your security firewall configuration.');
    }

    /**
     * @Route("/logout", name="admin_logout")
     */
    public function logoutAction()
    {
        throw new \RuntimeException('You must activate the logout in your security firewall configuration.');
    }

}
