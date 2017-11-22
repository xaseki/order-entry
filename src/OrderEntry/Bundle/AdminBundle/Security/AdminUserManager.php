<?php
namespace OrderEntry\Bundle\AdminBundle\Security;

use Doctrine\Common\Persistence\ObjectManager;
use FOS\UserBundle\Doctrine\UserManager;
use FOS\UserBundle\Util\CanonicalFieldsUpdater;
use FOS\UserBundle\Util\PasswordUpdaterInterface;
use OrderEntry\Bundle\AdminBundle\Entity\Admin;
use JMS\DiExtraBundle\Annotation as DI;
/**
 * Class AdminUserManager
 * @DI\Service()
 */
class AdminUserManager extends UserManager
{
    /**
     * Constructor.
     *
     * @param PasswordUpdaterInterface $passwordUpdater
     * @param CanonicalFieldsUpdater $canonicalFieldsUpdater
     * @param ObjectManager $om
     * @DI\InjectParams({
     *  "passwordUpdater"        = @DI\Inject("fos_user.util.password_updater"),
     *  "canonicalFieldsUpdater" = @DI\Inject("fos_user.util.canonical_fields_updater"),
     *  "om"                     = @DI\Inject("doctrine.orm.entity_manager")
     * })
     */
    public function __construct(PasswordUpdaterInterface $passwordUpdater, CanonicalFieldsUpdater $canonicalFieldsUpdater, ObjectManager $om)
    {
        parent::__construct($passwordUpdater, $canonicalFieldsUpdater, $om, Admin::class);
    }

}
