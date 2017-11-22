<?php
namespace OrderEntry\Bundle\AdminBundle\Command;

use Doctrine\ORM\EntityManager;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use OrderEntry\Bundle\AdminBundle\Security\AdminUserManipulator;

/**
 * @author Matthieu Bontemps <matthieu@knplabs.com>
 * @author Thibault Duplessis <thibault.duplessis@gmail.com>
 * @author Luis Cordova <cordoval@gmail.com> 
 */
class CreateUserCommand extends ContainerAwareCommand
{
    /**
     * @see Command
     */
    protected function configure()
    {
        $this
            ->setName('order:admin:user-create')
            ->setDescription('Create a user.')
            ->setDefinition(array(
                new InputArgument('username', InputArgument::REQUIRED, 'The username'),
                new InputArgument('email', InputArgument::REQUIRED, 'The email'),
                new InputArgument('password', InputArgument::REQUIRED, 'The password'),
                new InputArgument('role', InputArgument::OPTIONAL, 'The role'),
                new InputArgument('name', InputArgument::OPTIONAL, 'The name'),
                new InputOption('inactive', null, InputOption::VALUE_NONE, 'Set the user as inactive'),
            ))
            ->setHelp(<<<EOT
The <info>holiday:maintenance:user-create</info> command creates a user:

  <info>php holiday:maintenance:user-create matthieu</info>

This interactive shell will ask you for an email and then a password.

You can alternatively specify the email and password as the second and third arguments:

  <info>php app/console holiday:maintenance:user-create yamada yamada@example.com mypassword</info>

You can create a super admin via the super-admin flag:

You can create an inactive user (will not be able to log in):

  <info>php app/console fos:user:create thibault --inactive</info>

EOT
            );
    }

    /**
     * @see Command
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $username = $input->getArgument('username');
        $email = $input->getArgument('email');
        $password = $input->getArgument('password');
        $role = $input->getArgument('role');
        $name = $input->getArgument('name');
        $inactive = $input->getOption('inactive');

        /** @var AdminUserManipulator $manipulater */
        $manipulater = $this->getContainer()->get('order_entry.bundle.admin_bundle.security.admin_user_manipulator');
        $manipulater->create($username, $email, $password, !$inactive, $role, $name);

        $output->writeln(sprintf('Created user <comment>%s</comment>', $username));
    }

    /**
     * @see Command
     */
    protected function interact(InputInterface $input, OutputInterface $output)
    {
        if (!$input->getArgument('username')) {
            $username = $this->getHelper('dialog')->askAndValidate(
                $output,
                'Please choose a username:',
                function($username) {
                    if (!preg_match('/^[a-zA-Z0-9\!-\~]{4,}$/', $username)) {
                        throw new \Exception('4文字以上の英数字で入力してください');
                    }

                    return $username;
                }
            );
            $input->setArgument('username', $username);
        }

        if (!$input->getArgument('email')) {
            $email = $this->getHelper('dialog')->askAndValidate(
                $output,
                'Please choose an email:',
                function($email) {
                    if (empty($email)) {
                        throw new \Exception('Email can not be empty');
                    }

                    return $email;
                }
            );
            $input->setArgument('email', $email);
        }

        if (!$input->getArgument('password')) {
            $password = $this->getHelper('dialog')->askHiddenResponseAndValidate(
                $output,
                'Please choose a password:',
                function($password) {
                    if (!preg_match('/^[a-zA-Z0-9\!-\~]{4,}$/', $password)) {
                        throw new \Exception('4文字以上の英数字で入力してください');
                    }
                    return $password;
                }
            );
            $input->setArgument('password', $password);
        }
        if (!$input->getArgument('role')) {
            $choices = array(
                'ROLE_STAFF' => 'ROLE_MEMBER_A',
                'ROLE_ADMIN' => 'ROLE_ADMIN',
                'ROLE_SUPER_ADMIN' => 'ROLE_SUPER_ADMIN',
            );
            $role = $this->getHelper('dialog')->select(
                $output,
                'Please choose a role:',
                $choices
            );
            $input->setArgument('role', $choices[$role]);
        }
        if (!$input->getArgument('name')) {
            $name = $this->getHelper('dialog')->askAndValidate(
                $output,
                'Please input name:',
                function($name) {
                    if (empty($name)) {
                        throw new \Exception('Name can not be empty');
                    }
                    return $name;
                }
            );
            $input->setArgument('name', $name);
        }
    }

}