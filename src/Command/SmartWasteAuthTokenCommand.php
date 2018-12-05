<?php

namespace BespokeSupport\SmartWaste\Command;

use BespokeSupport\SmartWaste\SmartWaste;
use BespokeSupport\SmartWaste\SmartWasteCredentials;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class SmartWasteAuthTokenCommand extends Command
{
    public static $defaultName = 'sw:auth:token';

    public function configure()
    {
        $this->addArgument('user', InputArgument::REQUIRED, 'user');
        $this->addArgument('keyPublic', InputArgument::REQUIRED, 'keyPublic');
        $this->addArgument('keyPrivate', InputArgument::REQUIRED, 'keyPrivate');
    }

    public function execute(InputInterface $input, OutputInterface $output)
    {
        if (!$input->hasArgument('user') || !$input->hasArgument('keyPublic') || !$input->hasArgument('keyPrivate')) {
            $output->writeln('User and Public Key and Private Keys are required');
            exit;
        }

        $user = $input->getArgument('user');
        $keyPublic = $input->getArgument('keyPublic');
        $keyPrivate = $input->getArgument('keyPrivate');

        $cred = new SmartWasteCredentials($user, $keyPublic, $keyPrivate);

        $cred = SmartWaste::tokenize($cred);

        if (!$cred) {
            $output->writeln('User not found / Keys invalid');
            exit;
        }

        $output->writeln($cred->token);
    }
}