<?php

declare(strict_types=1);

namespace Cesc\Prima\Infrastructure\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Attribute\AsCommand;


class PrimaCommand extends Command
{
    protected static $defaultName = 'prima:test';

    protected function configure(): void
    {
        $this
            ->addArgument('input', InputArgument::OPTIONAL, 'Input');
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $output->writeln('Input: ' . $input->getArgument('input'));
        return Command::SUCCESS;
    }
}