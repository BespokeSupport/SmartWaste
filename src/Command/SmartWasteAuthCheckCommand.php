<?php

namespace BespokeSupport\SmartWaste\Command;

use BespokeSupport\SmartWaste\Method\AuthenticateUser;
use BespokeSupport\SmartWaste\SmartWaste;
use BespokeSupport\SmartWaste\SmartWasteCredentials;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class SmartWasteAuthCheckCommand extends Command
{
    public static $defaultName = 'sw:auth:check';

    public function configure()
    {
        $this->addArgument('user', InputArgument::REQUIRED, 'user');
        $this->addArgument('keyPublic', InputArgument::REQUIRED, 'keyPublic');
        $this->addArgument('keyPrivate', InputArgument::REQUIRED, 'keyPrivate');
    }

    public function execute(InputInterface $input, OutputInterface $output)
    {
        $username = $input->getArgument('username');
        $user = $input->getArgument('user');
        $keyPublic = $input->getArgument('keyPublic');
        $keyPrivate = $input->getArgument('keyPrivate');

        $cred = new SmartWasteCredentials($user, $keyPublic, $keyPrivate);

        $cred = SmartWaste::tokenize($cred);

        if (!$cred) {
            $output->writeln('User not found / Keys invalid');
            exit;
        }

        $res = SmartWaste::call($cred, new AuthenticateUser($username));

        if (!$res) {
            $output->writeln('User not found');
            exit;
        }

        if ($res->success) {
            $output->writeln('Success');
            exit;
        }

        $authenticationUrl = $res->authenticationUrl ?? null;

        $output->writeln($authenticationUrl);
    }
}