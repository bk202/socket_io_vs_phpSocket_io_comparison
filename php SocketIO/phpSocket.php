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

$userCnt = 0;
$maxUserCnt = 200;
$clientCutOffEvent = 400;
$cutOffEvent = $maxUserCnt * $clientCutOffEvent;
$io = new SocketIO(3120);
$eventCnt = 0;
$time_pre = microtime(true);
$io->on('connection', function($socket)use($io, $userCnt, $maxUserCnt, $cutOffEvent, $time_pre, &$eventCnt){
    $userCnt++;
    if($userCnt == $maxUserCnt){
        echo "Reached max user count!\n";
    }
    $socket->on('testEvent', function()use($socket, $cutOffEvent, &$eventCnt, $time_pre){
        $eventCnt++;
        if($eventCnt == $cutOffEvent){
            $time_post = microtime(true);
            echo $time_post - $time_pre;
        }
    });
});

// run all workers
Worker::runAll();


