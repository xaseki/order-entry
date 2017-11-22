<?php
namespace OrderEntry\Bundle\AdminBundle\Security;

use Doctrine\ORM\EntityManager;
use FOS\UserBundle\Model\UserManagerInterface;
use JMS\DiExtraBundle\Annotation as DI;
use OrderEntry\Bundle\AdminBundle\Entity\Admin;

/**
 * Class AdminUserManipulator
 * @DI\Service(public=true)
 */
class AdminUserManipulator
{

    /**
     * @var EntityManager
     */
    protected $em;

    /**
     * @var UserManagerInterface
     */
    protected $userManager;

    /**
     * @DI\InjectParams({
     *      "em" = @DI\Inject("doctrine.orm.default_entity_manager"),
     *      "userManager" = @DI\Inject("order_entry.bundle.admin_bundle.security.admin_user_manager")
     * })
     */
    public function __construct(EntityManager $em, UserManagerInterface $userManager)
    {
        $this->em = $em;
        $this->userManager = $userManager;
    }

    public function create($username, $email, $password, $active, $role, $name)
    {
        /** @var Admin $admin */
        $admin = $this->userManager->createUser();

        $admin->setUsername($username);
        $admin->setEmail($email);
        $admin->setPlainPassword($password);
        $admin->setEnabled((Boolean) $active);

        $admin->addRole($role);

        $admin->setName($name);

        $this->userManager->updateUser($admin);



        return $admin;
    }


    /**
     * Changes the password for the given user.
     *
     * @param string $username
     * @param string $password
     */
    public function changePassword($username, $password)
    {
        $admin = $this->findAdminByUsernameOrThrowException($username);
        $admin->setPlainPassword($password);
        $this->userManager->updateUser($admin);
    }

    /**
     * Changes the roles for the given user.
     *
     * @param string $username
     * @param array $roles
     */
    public function changeRoles($username, $roles)
    {
        $admin = $this->findAdminByUsernameOrThrowException($username);
        $admin->setRoles($roles);
        $this->userManager->updateUser($admin);
    }

    /**
     * Finds a user by his username and throws an exception if we can't find it.
     *
     * @param string $username
     *
     * @throws \InvalidArgumentException When user does not exist
     *
     * @return Admin
     */
    private function findAdminByUsernameOrThrowException($username)
    {
        $admin = $this->userManager->findUserByUsername($username);

        if (!$admin) {
            throw new \InvalidArgumentException(sprintf('Admin user identified by "%s" username does not exist.', $username));
        }

        return $admin;
    }

}
