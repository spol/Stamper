<?php

// namespace Spol\Stamper\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class BuildCommand extends Command
{
    protected function configure()
    {
        $this
            ->setName('build')
            ->setDescription('Greet someone')
            ->addArgument(
                'file',
                InputArgument::REQUIRED,
                'File to build'
            )
            ->addOption(
               'config',
               null,
               InputOption::VALUE_REQUIRED,
               'Config file to load (defaults to stamper.json)'
            )
			->addOption(
               'output',
               null,
               InputOption::VALUE_REQUIRED,
               'Output location (defaults to current folder).'
            )
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $file = $input->getArgument('file');
    	$file_fullpath = realpath($file);

        $fileinfo = new SplFileInfo($file_fullpath);

    	if (empty($file_fullpath))
    	{
    		$output->writeln("<error>File not found</error>");
    		return false;
    	}

    	$template = new StamperTemplate($file_fullpath);

        if ($input->getOption('config')) {
            $config_filename = $input->getOption('config');
            $config_fullpath = realpath($config_filename);

            if (empty($config_fullpath))
            {
	    		$output->writeln("<error>Config file not found</error>");
	    		return false;
            }

            if (!$template->set_config($config_fullpath))
            {
	    		$output->writeln("<error>Error parsing config file.</error>");
	    		return false;
            }
        }
        else if (file_exists($fileinfo->getPath() . '/stamper.json'))
        {
            if (!$template->set_config($fileinfo->getPath() . '/stamper.json'))
            {
	    		$output->writeln("<error>Error parsing config file.</error>");
	    		return false;
            }
        }


        if ($input->getOption('output'))
        {
			$output_filepath = $input->getOption('output');
        }
        else
        {
        	$output_filepath = $fileinfo->getPath() . '/' . $fileinfo->getBasename('.' . $fileinfo->getExtension()) . '.html';
        }

        $template->render_and_write($output_filepath);

        $output->writeln("Done.");
    }
}
