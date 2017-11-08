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
$io = new SocketIO(80);
$eventCnt = 0;
$lastRecordedTime = microtime(true);
$uid = 0;
$io->on('connection', function($socket)use($io, &$userCnt, $maxUserCnt, $cutOffEvent, $lastRecordedTime, &$eventCnt, &$uid){
    $socket->emit('generateUid', $uid++);

    $socket->on('sendInfo', function($info)use($socket){
        $decoded = json_decode($info, true);
        $returnString = (string)$decoded['uid'] ." : ". (string)$decoded['timeStamp'] . "\n";
        $returnResponse = ["s" => $returnString];

        file_put_contents("log.txt", "s: " . $returnResponse["s"], FILE_APPEND);
        $socket->emit('returnInfo', $returnResponse);
    });
});

// run all workers
Worker::runAll();


