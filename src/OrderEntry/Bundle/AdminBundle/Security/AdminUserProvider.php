<?php
namespace OrderEntry\Bundle\AdminBundle\Security;

use FOS\UserBundle\Model\UserManagerInterface;
use FOS\UserBundle\Security\UserProvider;
use JMS\DiExtraBundle\Annotation as DI;

/**
 * Class AdminUserProvider
 * @DI\Service()
 */
class AdminUserProvider extends UserProvider
{
    /**
     * Constructor.
     *
     * @param AdminUserManager $userManager
     * @DI\InjectParams({
     *     "userManager" = @DI\Inject("order_entry.bundle.admin_bundle.security.admin_user_manager")
     * })
     */
    public function __construct(AdminUserManager $userManager)
    {
        parent::__construct($userManager);
    }
}
