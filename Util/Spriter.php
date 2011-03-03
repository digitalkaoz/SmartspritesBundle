<?php

namespace rs\SmartspritesBundle\Util;

use Symfony\Component\HttpKernel\KernelInterface;
use Symfony\Component\Yaml\Yaml;
use Symfony\Bundle\FrameworkBundle\Util\Filesystem;
use Symfony\Component\Finder\Finder;
use Symfony\Component\Console\Output\OutputInterface;
use \InvalidArgumentException;

/**
 * Description of Spriter
 *
 * @author robert
 */
class Spriter
{
    
    protected   $finder, 
                $kernel,
                $options
    ;

    /**
     * shortcut for instanciation
     * 
     * @param KernelInterace $kernel
     * @param string $file
     * @return Spriter
     */
    public static function create(KernelInterface $kernel)
    {
        $instance = new self();        
        $instance->setKernel($kernel);
                
        return $instance;
    }
    
    /**
     * injects a kernel
     * 
     * @param KernelInterface $kernel
     * @return Spriter 
     */
    public function setKernel(KernelInterface $kernel)
    {
        $this->kernel = $kernel;
        
        return $this;
    }
        
    /**
     * injects an output
     * 
     * @param OutputInterface $output
     * @return Spriter 
     */
    public function setOutput(OutputInterface $output)
    {
        $this->output = $output;
        
        return $this;
    }
    
    /**
     * set the options
     * 
     * @param type $options
     * @return Spriter 
     */
    public function setOptions($options = array())
    {
        $this->option = $options;
        
        return $this;
    }
    
    /**
     * logs messages to output if available
     * 
     * @param string $msg 
     */
    public function log($msg)
    {
        if($this->output){
            $this->output->writeln($msg);
        }
    }
    
    /**
     * injects the finder
     * 
     * @param Finder $finder
     * @return Spriter 
     */
    public function setFinder(Finder $finder)
    {
        $this->finder = $finder;
        
        return $this;
    }
    
    /**
     * returns the finder
     * 
     * @return Finder
     */
    protected function getFinder()
    {
        if(!$this->finder){
            $this->finder = new Finder();
        }
        
        return $this->finder;
    }
    
    /**
     * generates the sprites
     * 
     * @param $files
     * @return Spriter
     */
    public function generateSprites($files = array())
    {
        $files = $this->getFiles($files);
        
        $params = $this->convertOptionsToCommandline();
        
        $this->execute($params);
        
        return $this;
    }
    
    /**
     * starts the sprite generation
     * 
     * @param array $params 
     */
    protected function execute($params)
    {
        $command = $this->buildCommand($params);
        
        $this->log(shell_exec($command));
        //$this->log($command);
    }
    
    /**
     * builds the shell command to execute
     * 
     * @param array $params
     * @return string 
     */
    protected function buildCommand($params)
    {
        $cli = '';
        
        foreach($params as $option => $arg){
            if(null !== $arg && is_string($arg)){
                $cli .= $option.' '.$arg.' ';
            }elseif(is_string($arg)){
                $cli .= $option.' ';                
            }
        }

        $script = "cd ".dirname(__FILE__)."/../vendor/smartsprites-0.2.8/ && ./smartsprites.sh";

        $command = $script." ".$cli;

        return $command;
    }
    
    /**
     * converts the option to smartsprites cli options
     * 
     * @return array 
     */
    protected function convertOptionsToCommandline()
    {
        $cli = array();
        
        $cli['--css-file-encoding'] = isset($this->options['encoding']) ? $this->options['encoding'] : 'UTF-8';
        $cli['--css-file-suffix'] = isset($this->options['suffix']) ? $this->options['suffix'] : $this->kernel->getContainer()->getParameter('smartsprites.suffix');
        $cli['--document-root-dir-path'] = $this->kernel->getRootDir().'/../web';
        $cli['--log-level'] = isset($this->options['loglevel']) ? $this->options['loglevel'] : 'ERROR';
        $cli['--root-dir-path'] = isset($this->options['input_dir']) ? $this->options['input_dir'] : $this->kernel->getContainer()->getParameter('smartsprites.input_dir');
        $cli['--output-dir-path'] = isset($this->options['output_dir']) ? $this->options['output_dir'] : $this->kernel->getContainer()->getParameter('smartsprites.output_dir');
        $cli['--sprite-png-depth'] = 'AUTO';
        $cli['--sprite-png-ie6'] = null;

        $files = $this->getFiles(isset($this->options['files']) ? $this->options['files'] : array());

        if($files){
            $cli['--css-files'] = join(' ',$this->getFiles());
        }
        
        return $cli;
    }
    
    /**
     * get the files for spriting
     * 
     * @param array $files
     * @return array
     */
    protected function getFiles($files = array())
    {
        $finder = $this->getFinder()->files();
        
        if(!$files){
            $finder->name('*.css');
        }else{
            foreach($files as $file){
                $finder->name($file);
            }
        }
        
        $files = array();
        
        foreach($finder->in($this->kernel->getRootDir())->getIterator() as $file){
            $files[] = $file;
        }
        
        return $files;
    }
    
}
