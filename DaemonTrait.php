<?php
/**
 * Created by PhpStorm.
 * User: shellus-out
 * Date: 2016/9/21
 * Time: 15:13
 */

namespace App\Console\Commands;

use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Illuminate\Console\Parser;
use Illuminate\Foundation\Inspiring;
use Symfony\Component\Console\Command\Command as SymfonyCommand;

/**
 * Class DaemonTrait
 * @package App\Console\Commands
 */
trait DaemonTrait
{
    protected $pidfile;
    protected $logfile;

    protected function configureUsingFluentDefinition()
    {
        list($name, $arguments, $options) = Parser::parse($this->signature);

        SymfonyCommand::__construct($name);

        foreach ($arguments as $argument) {
            $this->getDefinition()->addArgument($argument);
        }
        $options[] = new InputOption('s', null, 4);
        foreach ($options as $option) {
            $this->getDefinition()->addOption($option);
        }
    }
    private function runDaemon() {

        $pid = pcntl_fork();
        if ($pid == -1) {
            $this -> error('could not fork');
            return 1;
        } elseif ($pid) {
            return 0;
        } else {
            $this->output = new \Symfony\Component\Console\Output\StreamOutput(fopen($this->logfile,'w+'));
            file_put_contents($this->pidfile, getmypid());
            $method = method_exists($this, 'handle') ? 'handle' : 'fire';
            return $this-> laravel ->call([$this, $method]);
        }
    }
    protected function execute(InputInterface $input, OutputInterface $output)
    {


        if($action = $this -> option('s'))
        {

            $this -> pidfile = storage_path('/') . $this -> getName() . '.pid';
            $this -> logfile = storage_path('logs/') . $this -> getName() . '.log';

            switch ($action){
                case 'start':
                    if (file_exists($this->pidfile)) {
                        $this -> error('The process already exists');
                        exit();
                    }
                    if($this -> runDaemon() == 0)
                    {
                        $this -> info('The process has been start');
                    }
                    break;
                case 'stop':
                    if (file_exists($this->pidfile)) {
                        $pid = file_get_contents($this->pidfile);
                        posix_kill($pid, 9);
                        unlink($this->pidfile);
                    }
                    $this -> info('The process has been stop');
                    break;
                case 'status':
                    if (file_exists($this->pidfile)) {
                        $pid = file_get_contents($this->pidfile);
                        system(sprintf("ps ax | grep %s | grep -v grep", $pid));
                    }
//                    $this -> info('not status');
                    break;
            }

            return 0;
        }else
        {
            parent::execute($input, $output);
        }
    }

}