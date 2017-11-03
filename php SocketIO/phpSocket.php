<?php
/**
 * Created by PhpStorm.
 * User: johnliu95
 * Date: 2017-10-31
 * Time: 5:02 PM
 */
require_once __DIR__ . '/vendor/autoload.php';
use Workerman\Worker;
use PHPSocketIO\SocketIO;

$io = new SocketIO(3120);
$io->on('connection', function($socket)use($io){
    /*$time_pre = microtime(true);
    $socket->on('testEvent', function($msg)use($socket, $time_pre){
        //echo $msg . "\n";
        if($msg == 220000){
            $time_post = microtime(true);
            echo $time_post - $time_pre;
        }
    });*/
    for($i = 0; $i <= 10000; $i++){
        $socket->emit("testEvent", $i);
    }
    echo "done\n";
});

// run all workers
Worker::runAll();


