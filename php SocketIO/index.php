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
    echo"new user connected\n";
});

Worker::runAll();

?>


