<?php

namespace App\Command;

use App\Entity\User;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use RuntimeException;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

#[AsCommand(
    name: 'app:create-user',
    description: 'Creates a new user and store it in the database',
)]
class CreateUserCommand extends Command
{
    // the name of the command (the part after "bin/console")
    protected static $defaultName = 'app:create-user';

    public function __construct(
        private EntityManagerInterface $entityManager,
        private UserPasswordHasherInterface $passwordHasher,
        private UserRepository $users
    ) {
        parent::__construct();
    }
    protected function configure(): void
    {
        $this
            ->addArgument('firstname', InputArgument::REQUIRED, 'The firstname of the new user')
            ->addArgument('lastname', InputArgument::REQUIRED, 'The lastname of the new user')
            ->addArgument('email', InputArgument::REQUIRED, 'The email of the new user')
            ->addArgument('password', InputArgument::REQUIRED, 'The plain password of the new user')
            ->addOption('admin', 'a', InputOption::VALUE_NONE, 'If set, the user is created as an administrator');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);

        $output->writeln([
            'User Creator',
            '============',
            '',
        ]);

        $firstname = $input->getArgument('firstname');
        $lastname = $input->getArgument('lastname');
        $plainPassword = $input->getArgument('password');
        $email = $input->getArgument('email');
        $isAdmin = $input->getOption('admin');

        $this->validateUserData($email);

        $user = new User();
        $user->setFirstname($firstname);
        $user->setLastname($lastname);
        $user->setEmail($email);
        $user->setRoles([$isAdmin ? 'ROLE_ADMIN' : 'ROLE_USER']);

        $hashedPassword = $this->passwordHasher->hashPassword($user, $plainPassword);
        $user->setPassword($hashedPassword);

        $this->entityManager->persist($user);
        $this->entityManager->flush();

        $io->success(sprintf('%s was successfully created: %s (%s)', $isAdmin ? 'Administrator user' : 'User', $user->getFirstname() . " " . $user->getLastname(), $user->getEmail()));

        return Command::SUCCESS;
    }

    private function validateUserData($email): void
    {
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            throw new RuntimeException(sprintf('This "%s" is not a valid email.', $email));
        }

        // first check if a user with the same email already exists.
        $existingUser = $this->users->findOneBy(['email' => $email]);

        if (null !== $existingUser) {
            throw new RuntimeException(sprintf('There is already a user registered with the "%s" email.', $email));
        }

        // validate password and email if is not this input means interactive.
        // $this->validator->validatePassword($plainPassword);
        // $this->validator->validateEmail($email);
        // $this->validator->validateFullName($fullName);
    }
}
