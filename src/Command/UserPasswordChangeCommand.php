<?php

namespace App\Command;

use App\Util\UserTools;
use App\Util\Validator;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

class UserPasswordChangeCommand extends Command
{
    protected static $defaultName = 'neko:user:password-change';

    /**
     * @var SymfonyStyle
     */
    private $io;
    /**
     * @var UserTools
     */
    private $userTools;
    /**
     * @var Validator
     */
    private $validator;

    public function __construct(Validator $validator, UserTools $userTools)
    {
        parent::__construct();
        $this->validator = $validator;
        $this->userTools = $userTools;
    }

    protected function configure()
    {
        $this
            ->setDescription('Add a short description for your command')
            ->addArgument('username', InputArgument::OPTIONAL, 'The user name')
            ->addArgument('password', InputArgument::OPTIONAL, 'The user name')
            ->addArgument('password_validate', InputArgument::OPTIONAL, 'The user name')
        ;
    }

    /**
     * This optional method is the first one executed for a command after configure()
     * and is useful to initialize properties based on the input arguments and options.
     * @param InputInterface $input
     * @param OutputInterface $output
     */
    protected function initialize(InputInterface $input, OutputInterface $output)
    {
        // SymfonyStyle is an optional feature that Symfony provides so you can
        // apply a consistent look to the commands of your application.
        // See https://symfony.com/doc/current/console/style.html
        $this->io = new SymfonyStyle($input, $output);
    }


    /**
     * This method is executed after initialize() and before execute(). Its purpose
     * is to check if some of the options/arguments are missing and interactively
     * ask the user for those values.
     *
     * This method is completely optional. If you are developing an internal console
     * command, you probably should not implement this method because it requires
     * quite a lot of work. However, if the command is meant to be used by external
     * users, this method is a nice way to fall back and prevent errors.
     */
    protected function interact(InputInterface $input, OutputInterface $output)
    {
        if (null !== $input->getArgument('username') && null !== $input->getArgument('password') && null !== $input->getArgument('email') && null !== $input->getArgument('full-name')) {
            return;
        }
        $this->io->title('Change the password of one user');

        // Ask for the username if it's not defined
        $username = $input->getArgument('username');
        if (null !== $username) {
            $this->io->text(' > <info>Username</info>: '.$username);
        } else {
            $username = $this->io->ask('Username', null, [$this->validator, 'validateUsername']);
            $input->setArgument('username', $username);
        }
        // Ask for the password if it's not defined
        $password = $input->getArgument('password');
        if (null !== $password) {
            $this->io->text(' > <info>Password</info>: '.str_repeat('*', mb_strlen($password)));
        } else {
            $password = $this->io->askHidden('Password (your type will be hidden)', [$this->validator, 'validatePassword']);

        }
        // Ask for the password again to validate it
        $password_validate = $input->getArgument('password_validate');
        if (null !== $password_validate) {
            $this->io->text(' > <info>Validate password</info>: '.str_repeat('*', mb_strlen($password)));
        } else {
            $password_validate = $this->io->askHidden('Validate password (your type will be hidden)', [$this->validator, 'validatePassword']);

        }

        if($password != $password_validate) {
            return;
        }

        $input->setArgument('password', $password);

    }


    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $io = new SymfonyStyle($input, $output);

        $username = $input->getArgument('username');
        $password = $input->getArgument('password');

        $this->userTools->changeUserPassword($username, $password);

        $io->success('La contraseña se ha cambiado correctamente.');
    }
}
