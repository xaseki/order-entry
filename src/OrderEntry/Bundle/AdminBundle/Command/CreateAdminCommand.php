<?php

namespace OrderEntry\Bundle\AdminBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Question\ChoiceQuestion;
use Symfony\Component\Console\Question\Question;
use OrderEntry\Bundle\AdminBundle\Security\AdminUserManipulator;
/**
 * @author Matthieu Bontemps <matthieu@knplabs.com>
 * @author Thibault Duplessis <thibault.duplessis@gmail.com>
 * @author Luis Cordova <cordoval@gmail.com>
 */
class CreateAdminCommand extends ContainerAwareCommand
{
    /**
     * @see Command
     */
    protected function configure()
    {
        $this
            ->setName('order-entry:admin:create')
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
        $helper = $this->getHelper('question');
    
        if (!$input->getArgument('username')) {
            
            $question = new Question('Please input an username:');
            $question->setValidator(
                function($username) {
                    if (!preg_match('/^[a-zA-Z0-9\!-\~]{4,}$/', $username)) {
                        throw new \Exception('4文字以上の英数字で入力してください');
                    }
        
                    return $username;
                }
            );
    
            $username = $helper->ask($input, $output, $question);
          
            $input->setArgument('username', $username);
        }

        
        if (!$input->getArgument('email')) {
            
            $question = new Question('Please input an email:');
            $question->setValidator(
                function($email) {
                    if (empty($email)) {
                        throw new \Exception('Email can not be empty');
                    }
        
                    return $email;
                }
            );
    
            $email = $helper->ask($input, $output, $question);
            
            $input->setArgument('email', $email);
        }

        
        if (!$input->getArgument('password')) {
            
            $question = new Question('Please input a password:');
            $question->setValidator(
                function($password) {
                    if (!preg_match('/^[a-zA-Z0-9\!-\~]{4,}$/', $password)) {
                        throw new \Exception('4文字以上の英数字で入力してください');
                    }
                    return $password;
                }
            );
            $question->setHidden(true);
    
            $password = $helper->ask($input, $output, $question);
    
            $input->setArgument('password', $password);
        }
        
        
        if (!$input->getArgument('role')) {
    
            $question = new ChoiceQuestion(
                'Please choose a role:',
                array(
                    'ROLE_MEMBER_A' => 'ROLE_MEMBER_A',
                    'ROLE_STAFF' => 'ROLE_STAFF',
                    'ROLE_ADMIN' => 'ROLE_ADMIN',
                    'ROLE_SUPER_ADMIN' => 'ROLE_SUPER_ADMIN',
                )
            );
            $question->setErrorMessage('ROLE %s is invalid.');
            
            $role = $helper->ask($input, $output, $question);
    
            $input->setArgument('role', $role);
        }
        
        
        if (!$input->getArgument('name')) {
    
            $question = new Question('Please input name:');
            $question->setValidator(
                function($name) {
                    if (empty($name)) {
                        throw new \Exception('Name can not be empty');
                    }
                    return $name;
                }
            );
    
            $name = $helper->ask($input, $output, $question);
            
            $input->setArgument('name', $name);
        }
    }

}
