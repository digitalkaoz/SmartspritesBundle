<?php

namespace rs\SmartspritesBundle\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\StringInput;
use Symfony\Component\Console\Input\ArrayInput;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Output\Output;
use Symfony\Bundle\FrameworkBundle\Util\Mustache;
use Symfony\Bundle\FrameworkBundle\Console\Application;

use rs\SmartspritesBundle\Util\Spriter;

/**
 * a simple command to work with smartsprites
 * 
 * @author Robert Schönthal <seroscho@googlemail.com>
 * @package rs.ProjectUtitlitiesBundle
 * @subpackage Command
 */
class SmartspritesCommand extends Command
{
	/**
	 * @see Command
	 */
	protected function configure()
	{
//        [CSS-FILES ...] 
//        [--css-file-encoding VAL] 
//        [--css-file-suffix VAL] 
//        [--css-files FILES ...] 
//        [--document-root-dir-path DIR] 
//        [--log-level [INFO | IE6NOTICE | DEPRECATION | WARN | ERROR | STATUS]] 
//        [--output-dir-path DIR] 
//        [--root-dir-path DIR] 
//        [--sprite-png-depth [AUTO | INDEXED | DIRECT]] 
//        [--sprite-png-ie6]
        
		$this
				->setDefinition(array(
					//new InputOption('config', 'c', InputOption::VALUE_OPTIONAL, 'config file to use'),
					new InputArgument('action', InputArgument::OPTIONAL, 'action to do (generate)'),
				))
				->setHelp(<<<EOT
The <info>assets:sprites</info> command generates sprites from your prepared css files

See <comment>http://csssprites.org/#tutorials</comment> how to prepare your css
EOT
				)
				->setName('assets:sprites')
                ->setDescription('generate css sprites using smartsprites')
		;
	}

	/**
	 * @see Command
	 */
	protected function execute(InputInterface $input, OutputInterface $output)
	{
		$this->output = $output;

		if(!$this->application){
			$this->setApplication(new Application($this->container->get('kernel')));
		}
        
        $spriter = $this->getSpriter($input, $output);
        
        if('generate' == $input->getArgument('action') || !$input->getArgument('action')){
            $spriter->generateSprites();
        }
        
	}
    
    /**
     *
     * @param InputInterface $input
     * @param OutputInterface $output
     * @return Spriter 
     */
    protected function getSpriter(InputInterface $input, OutputInterface $output)
    {
        $spriter = $this->application->getKernel()->getContainer()->get('smartsprites');
        
        /**
         * @var Spriter $spriter
         */        
        $spriter
            ->setKernel($this->application->getKernel())
            ->setOptions($input->getOptions())
            ->setOutput($output)
        ;

        return $spriter;
    }
	
}
