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

// #### http worker ####
$web = new Worker('http://0.0.0.0:3000');
$web->onMessage = function($connection, $data)
{
    $content = file_get_contents(__DIR__ . '/index.html');
    for($i=0; $i<=10; $i++){
        $connection->send($content);
    }
};

// run all workers
Worker::runAll();


