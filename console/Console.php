<?php
/**
 * Created by PhpStorm.
 * User: shellus-out
 * Date: 2016/9/16
 * Time: 9:41
 */
abstract class Console
{
    protected $name = 'php-work';
    protected $pid_file_dir = '';
    protected $pid_file = '';
    public function __construct($name = 'php-work')
    {
        $this -> name = $name;
        $pid = posix_getpid();
        $this -> registerSigHandlers();
        $this -> setProcessName($this -> name);
        $this -> setPidFile($pid);
        $this -> startup();
    }

    abstract function run();

    public function startup($is_daemon_mode = false)
    {
        if($is_daemon_mode){
            $this -> info('in daemon mode');
            $status = pcntl_fork();
            if ($status === -1){
                throw new RuntimeException('could not fork');
            }elseif($status){
                // 主进程操作
            }else{
                // 子进程操作
                $this -> run();
            }
        }else{
            $this -> info('not daemon mode');
            $this -> run();
        }

    }
    public function shutdown($signal)
    {
        $this -> info('收到退出信号');
//        @unlink($this -> pid_file);
//        exit(signal);
    }
    protected function registerSigHandlers()
    {
//        pcntl_signal(SIGTERM, [$this, 'shutdown']);
        pcntl_signal(SIGINT, [$this, 'shutdown']);
//        pcntl_signal(SIGQUIT, [$this, 'shutdown']);
//        pcntl_signal(SIGUSR1, [$this, 'shutdown']);
    }
    private function setPidFile($pid)
    {
        $this -> pid_file = $this -> pid_file_dir . $this -> name . '.pid';
        $result = file_put_contents($this -> pid_file, $pid);
        if ($result === false){
            throw new RuntimeException('pid write fail');
        }
    }

    private function setProcessName($name){
        cli_set_process_title($name);
        return;
    }

    public function info($var){
        echo $var;
        echo PHP_EOL;
    }

}
class SleepProcess extends Console
{
    protected function run()
    {
        $this -> info('我开始睡觉');
        $time = 10;
        while ($time --> 1){
            sleep(1);
            $this -> info('zzz ~');
            pcntl_signal_dispatch();
        }
        $this -> info('我睡醒了');
    }
}
new SleepProcess();