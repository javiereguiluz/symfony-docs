#!/usr/bin/env php
<?php
require __DIR__.'/vendor/autoload.php';

use Symfony\Component\Console\Application;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Process\Process;
use Symfony\Component\Process\Exception\ProcessFailedException;

(new Application('Symfony Docs Builder', '1.0'))
    ->register('build-docs')
    ->setCode(function(InputInterface $input, OutputInterface $output) {
        $command = [
            'php',
            'vendor/symfony/docs-builder/bin/console',
            'build:docs',
            '--output-json',
            __DIR__.'/../',
            __DIR__.'/output/',
        ];
        $vars = [];
/*
        if (!$docsBuild->shouldUseCache()) {
            $command[] = '--disable-cache';
        }

        if (null !== $docsBuild->getLogsPath()) {
            $command[] = sprintf('--save-errors=%s', $docsBuild->getLogsPath());
        }
*/
        //$vars['SYMFONY_VERSION'] = '4.4';

        $process = new Process($command, null, $vars);
        $process->run();

        if (!$process->isSuccessful()) {
            throw new ProcessFailedException($process);
        }
    })
    ->getApplication()
    ->setDefaultCommand('build-docs', true)
    ->run();
