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

function getCurrentTime(){
    $t = microtime(true);
    $micro = sprintf("%06d",($t - floor($t)) * 1000000);
    $d = new DateTime( date('Y-m-d H:i:s.'.$micro, $t) );

    return $d->format("Y-m-d H:i:s.u"); // note at point on "u"
}

$userCnt = 0;
$maxUserCnt = 200;
$clientCutOffEvent = 400;
$cutOffEvent = $maxUserCnt * $clientCutOffEvent;
$io = new SocketIO(2020);
$eventCnt = 0;
$lastRecordedTime = microtime(true);
$uid = 0;
$avgTimeDiff = 0;
$io->on('connection', function($socket)use($io, &$userCnt, $maxUserCnt, $cutOffEvent, $lastRecordedTime, &$eventCnt, &$uid, &$avgTimeDiff){
    $socket->emit('generateUid', $uid++);

    $socket->on('sendInfo', function($info)use($socket, &$avgTimeDiff, &$eventCnt, $maxUserCnt){
        $eventCnt++;
        $decoded = json_decode($info, true);
        $returnString = (string)$decoded['uid'] ." : ". (string)$decoded['timeStamp'] . "\n";
        $returnResponse = ["s" => $returnString];

        $serverTime = microtime(true) * 1000;
        $clientTime = $decoded["milliseconds"];
        $timeDiff = $serverTime - $clientTime;
        $avgTimeDiff += $timeDiff;

        file_put_contents("log.txt", "s: " . $returnResponse["s"], FILE_APPEND);
        file_put_contents("log.txt", "System time: " . getCurrentTime() . "\n", FILE_APPEND);
        file_put_contents("log.txt", "time difference: " . $timeDiff . " milliseconds". "\n", FILE_APPEND);
        if($eventCnt == $maxUserCnt){
            $avgTimeDiff /= $maxUserCnt;
            file_put_contents("log.txt", "Average time difference: $avgTimeDiff", FILE_APPEND);
        }
        $socket->emit('returnInfo', $returnResponse);
    });
});

// run all workers
Worker::runAll();


